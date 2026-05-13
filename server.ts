import express from "express";
import { createServer as createViteServer } from "vite";
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
    ssl: process.env.NODE_ENV === 'production' ? { rejectUnauthorized: false } : false
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
  // Initialize Tables
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

  // Seed Data if empty
  const wardCount = await dbGet("SELECT COUNT(*) as count FROM wards") as { count: number | string };
  if (Number(wardCount.count) === 0) {
    await dbRun("INSERT INTO wards (id, name, type, capacity) VALUES (?, ?, ?, ?)", ["w1", "Nightingale", "General", 12]);
    
    const initialPatients = [
      { id: 'p1', name: 'Robert Thompson', priority: 'high', note: 'Vital check in 15m', dob: '12-May-55', marital_status: 'Married', registered_at: '12-Jan-26', type: 'IN-PATIENT' },
      { id: 'p2', name: 'Eliza Bennett', priority: 'medium', note: 'Pending discharge: 16:00', dob: '03-Jun-82', marital_status: 'Single', registered_at: '15-Feb-26', type: 'IN-PATIENT' },
      { id: 'p3', name: 'Arthur Miller', priority: 'medium', note: 'Post-op recovery', dob: '22-Aug-48', marital_status: 'Married', registered_at: '20-Mar-26', type: 'IN-PATIENT' },
      { id: 'p4', name: 'Samuel Clarke', priority: 'low', note: 'Standard Monitoring', dob: '10-Oct-70', marital_status: 'Divorced', registered_at: '05-Apr-26', type: 'IN-PATIENT' },
      { id: 'p5', name: 'Linda Grey', priority: 'low', note: 'Medication administered', dob: '15-Dec-65', marital_status: 'Widowed', registered_at: '10-May-26', type: 'IN-PATIENT' },
      { id: 'p6', name: 'James Wilson', priority: 'high', note: 'Oxygen levels monitoring', dob: '28-Feb-50', marital_status: 'Married', registered_at: '12-May-26', type: 'IN-PATIENT' },
      { id: 'p7', name: 'Purple Rain', priority: 'high', note: 'Regular checkup', dob: '09-Sep-60', marital_status: 'Single', registered_at: '12-May-26', type: 'IN-PATIENT' },
      { id: 'p8', name: 'Kwis Cabang', priority: 'medium', note: 'Outpatient consult', dob: '31-Aug-77', marital_status: 'Married', registered_at: '13-Jan-26', type: 'OUT-PATIENT' },
      { id: 'p9', name: 'Christian Pausanos', priority: 'low', note: 'Stable', dob: '31-Mar-75', marital_status: 'Married', registered_at: '12-May-26', type: 'IN-PATIENT' },
    ];

    for (const p of initialPatients) {
      await dbRun("INSERT INTO patients (id, name, priority, note, dob, marital_status, registered_at, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [p.id, p.name, p.priority, p.note, p.dob, p.marital_status, p.registered_at, p.type]);
    }

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
      { id: '1', label: '01', status: 'occupied', patient_id: 'p1' },
      { id: '2', label: '02', status: 'occupied', patient_id: 'p2' },
      { id: '3', label: '03', status: 'available', patient_id: null },
      { id: '4', label: '04', status: 'cleaning', patient_id: null },
      { id: '5', label: '05', status: 'occupied', patient_id: 'p3' },
      { id: '6', label: '06', status: 'occupied', patient_id: 'p4' },
      { id: '7', label: '07', status: 'occupied', patient_id: 'p5' },
      { id: '8', label: '08', status: 'available', patient_id: null },
      { id: '9', label: '09', status: 'occupied', patient_id: 'p6' },
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
  const PORT = 3000;

  app.use(cors());
  app.use(express.json());

  // API Routes
  
  // 1. Maintain Ward Details
  app.get("/api/ward", async (req, res) => {
    const ward = await dbGet("SELECT * FROM wards LIMIT 1");
    res.json(ward);
  });

  app.patch("/api/ward", async (req, res) => {
    const { type, capacity } = req.body;
    await dbRun("UPDATE wards SET type = ?, capacity = ?", [type, capacity]);
    res.json({ success: true });
  });

  // 2. Manage Bed Allocation and Availability
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

  // 3. Update Bed Status (Cleaning, Available, etc.)
  app.patch("/api/beds/:id/status", async (req, res) => {
    const { status } = req.body;
    await dbRun("UPDATE beds SET status = ?, patient_id = CASE WHEN ? = 'occupied' THEN patient_id ELSE NULL END WHERE id = ?", [status, status, req.params.id]);
    res.json({ success: true });
  });

  // 4. Assign Bed to Patient
  app.post("/api/beds/:id/assign", async (req, res) => {
    const { patientId } = req.body;
    // Check if patient exists
    const patient = await dbGet("SELECT * FROM patients WHERE id = ?", [patientId]);
    if (!patient) return res.status(404).json({ error: "Patient not found" });

    await dbRun("UPDATE beds SET status = 'occupied', patient_id = ? WHERE id = ?", [patientId, req.params.id]);
    res.json({ success: true });
  });

  // 5. Patients Endpoints
  app.get("/api/patients", async (req, res) => {
    const patients = await dbAll("SELECT * FROM patients");
    res.json(patients);
  });

  // 6. Staff Endpoints
  app.get("/api/staff", async (req, res) => {
    const staff = await dbAll("SELECT * FROM staff");
    res.json(staff);
  });

  // 7. Notes Endpoints
  app.get("/api/notes", async (req, res) => {
    const notes = await dbAll("SELECT * FROM notes");
    res.json(notes);
  });

  // Vite middleware for development
  if (process.env.NODE_ENV !== "production") {
    const vite = await createViteServer({
      server: { middlewareMode: true },
      appType: "spa",
    });
    app.use(vite.middlewares);
  } else {
    const distPath = path.join(process.cwd(), "dist");
    app.use(express.static(distPath));
    app.get("*", (req, res) => {
      res.sendFile(path.join(distPath, "index.html"));
    });
  }

  app.listen(PORT, "0.0.0.0", () => {
    console.log(`Server running on http://localhost:${PORT}`);
  });
}

startServer();
