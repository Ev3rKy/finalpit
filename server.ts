import express from "express";
import path from "path";
import Database from "better-sqlite3";
import { Pool } from "pg";
import cors from "cors";

// Database Setup
const usePostgres = !!process.env.DATABASE_URL;
let sqliteDb: any = null;
let pgPool: Pool | null = null;

if (usePostgres) {
  pgPool = new Pool({
    connectionString: process.env.DATABASE_URL,
    ssl: { rejectUnauthorized: false }
  });
} else {
  sqliteDb = new Database("hospital.db");
}

// Database Helpers
async function dbExec(sql: string) {
  if (usePostgres) {
    await pgPool!.query(sql);
  } else {
    sqliteDb.exec(sql);
  }
}

async function dbGet(sql: string, params: any[] = []) {
  let counter = 1;
  const transformedSql = sql.replace(/\?/g, () => `$${counter++}`);

  if (usePostgres) {
    const res = await pgPool!.query(transformedSql, params);
    return res.rows[0];
  } else {
    return sqliteDb.prepare(sql).get(...params);
  }
}

async function dbAll(sql: string, params: any[] = []) {
  let counter = 1;
  const transformedSql = sql.replace(/\?/g, () => `$${counter++}`);

  if (usePostgres) {
    const res = await pgPool!.query(transformedSql, params);
    return res.rows;
  } else {
    return sqliteDb.prepare(sql).all(...params);
  }
}

async function dbRun(sql: string, params: any[] = []) {
  let counter = 1;
  const transformedSql = sql.replace(/\?/g, () => `$${counter++}`);

  if (usePostgres) {
    await pgPool!.query(transformedSql, params);
  } else {
    sqliteDb.prepare(sql).run(...params);
  }
}

async function initDb() {
  // Keeps existing tables exactly as they are without re-creating them
  await dbExec(`
    CREATE TABLE IF NOT EXISTS wards (
      id TEXT PRIMARY KEY,
      name TEXT NOT NULL,
      type TEXT NOT NULL,
      capacity INTEGER NOT NULL
    );

    CREATE TABLE IF NOT EXISTS patients (
      id TEXT PRIMARY KEY,
      name TEXT NOT NULL,
      priority TEXT NOT NULL,
      note TEXT,
      dob TEXT,
      marital_status TEXT,
      registered_at TEXT,
      type TEXT
    );

    CREATE TABLE IF NOT EXISTS staff (
      id TEXT PRIMARY KEY,
      name TEXT NOT NULL,
      role TEXT NOT NULL,
      status TEXT NOT NULL,
      avatar TEXT
    );

    CREATE TABLE IF NOT EXISTS notes (
      id TEXT PRIMARY KEY,
      author TEXT NOT NULL,
      content TEXT NOT NULL,
      time TEXT NOT NULL
    );

    CREATE TABLE IF NOT EXISTS beds (
      id TEXT PRIMARY KEY,
      label TEXT NOT NULL,
      status TEXT NOT NULL,
      patient_id TEXT REFERENCES patients(id)
    );
  `);

  // Seeds baseline layout values only if completely unpopulated
  const wardCount = await dbGet("SELECT COUNT(*) as count FROM wards") as { count: number | string };
  if (Number(wardCount.count) === 0) {
    await dbRun("INSERT INTO wards (id, name, type, capacity) VALUES (?, ?, ?, ?)", ["w1", "Nightingale", "General", 12]);

    const staff = [
      { id: 's1', name: 'Sarah Jenkins', role: 'Charge Nurse', status: 'On Duty', avatar: 'https://images.unsplash.com/photo-1559839734-2b71f1536783?auto=format&fit=crop&q=80&w=100&h=100' },
      { id: 's2', name: 'Dr. Michael Chen', role: 'Consultant', status: 'On Duty', avatar: 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&q=80&w=100&h=100' },
      { id: 's3', name: 'Emma Watson', role: 'Staff Nurse', status: 'On Break', avatar: 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&q=80&w=100&h=100' },
    ];

    for (const s of staff) {
      await dbRun("INSERT INTO staff (id, name, role, status, avatar) VALUES (?, ?, ?, ?, ?)", [s.id, s.name, s.role, s.status, s.avatar]);
    }

    const initialNotes = [
      { id: 'n1', author: 'Nurse Sarah J.', content: 'Oxygen levels in storage B are running low. Replacement delivery expected by 18:00 today.', time: '12:30' },
      { id: 'n2', author: 'Dr. Julian B.', content: 'Check patient in Bed 05 for post-op dizziness every 2 hours.', time: '14:00' },
      { id: 'n3', author: 'Dr. Julian B.', content: 'Bed 04 deep clean finished, waiting for final inspection.', time: '15:15' },
    ];

    for (const n of initialNotes) {
      await dbRun("INSERT INTO notes (id, author, content, time) VALUES (?, ?, ?, ?)", [n.id, n.author, n.content, n.time]);
    }

    const beds = [
      { id: '1', label: '01', status: 'available', patient_id: null },
      { id: '2', label: '02', status: 'available', patient_id: null },
      { id: '3', label: '03', status: 'available', patient_id: null },
      { id: '4', label: '04', status: 'cleaning', patient_id: null },
      { id: '5', label: '05', status: 'available', patient_id: null },
      { id: '6', label: '06', status: 'available', patient_id: null },
      { id: '7', label: '07', status: 'available', patient_id: null },
      { id: '8', label: '08', status: 'available', patient_id: null },
      { id: '9', label: '09', status: 'available', patient_id: null },
      { id: '10', label: '10', status: 'available', patient_id: null },
      { id: '11', label: '11', status: 'cleaning', patient_id: null },
      { id: '12', label: '12', status: 'available', patient_id: null },
    ];

    for (const b of beds) {
      await dbRun("INSERT INTO beds (id, label, status, patient_id) VALUES (?, ?, ?, ?)", [b.id, b.label, b.status, b.patient_id]);
    }
  }
}

async function startServer() {
  await initDb();
  
  const app = express();
  const PORT = process.env.PORT || 3000;

  app.use(cors());
  app.use(express.json());

  // API Routes
  app.get("/api/ward", async (req, res) => {
    const ward = await dbGet("SELECT * FROM wards LIMIT 1");
    res.json(ward);
  });

  app.patch("/api/ward", async (req, res) => {
    const { type, capacity } = req.body;
    await dbRun("UPDATE wards SET type = ?, capacity = ?", [type, capacity]);
    res.json({ success: true });
  });

  app.get("/api/beds", async (req, res) => {
    const beds = await dbAll(`
      SELECT b.*, p.name as patient_name, p.priority as patient_priority, p.note as patient_note
      FROM beds b
      LEFT JOIN patients p ON b.patient_id = p.id
    `);

    const formattedBeds = beds.map((b: any) => ({
      id: b.id,
      label: b.label,
      status: b.status,
      patient: b.patient_id ? {
        id: b.patient_id,
        name: b.patient_name,
        priority: b.patient_priority,
        note: b.patient_note
      } : undefined
    }));

    res.json(formattedBeds);
  });

  app.patch("/api/beds/:id/status", async (req, res) => {
    const { status } = req.body;
    await dbRun("UPDATE beds SET status = ?, patient_id = CASE WHEN ? = 'occupied' THEN patient_id ELSE NULL END WHERE id = ?", [status, status, req.params.id]);
    res.json({ success: true });
  });

  app.post("/api/beds/:id/assign", async (req, res) => {
    const { patientId } = req.body;
    const patient = await dbGet("SELECT * FROM patients WHERE id = ?", [patientId]);
    if (!patient) return res.status(404).json({ error: "Patient not found" });

    await dbRun("UPDATE beds SET status = 'occupied', patient_id = ? WHERE id = ?", [patientId, req.params.id]);
    res.json({ success: true });
  });

  // Fetching Patients directly from your active database records
  app.get("/api/patients", async (req, res) => {
    const patients = await dbAll("SELECT * FROM patients");
    res.json(patients);
  });

  app.get("/api/staff", async (req, res) => {
    const staff = await dbAll("SELECT * FROM staff");
    res.json(staff);
  });

  app.get("/api/notes", async (req, res) => {
    const notes = await dbAll("SELECT * FROM notes");
    res.json(notes);
  });

  const distPath = path.join(process.cwd(), "dist");
  app.use(express.static(distPath));
  app.get("*", (req, res) => {
    res.sendFile(path.join(distPath, "index.html"));
  });

  app.listen(Number(PORT), "0.0.0.0", () => {
    console.log(`Server running safely on port ${PORT}`);
  });
}

startServer();
