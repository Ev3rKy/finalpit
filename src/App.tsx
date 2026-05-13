import { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'motion/react';
import { Sidebar } from './components/layout/Sidebar';
import { Header } from './components/layout/Header';
import { BedGrid } from './components/ward/BedGrid';
import { StaffList } from './components/ward/StaffList';
import { WardStats } from './components/ward/WardStats';
import { LoginPage } from './components/auth/LoginPage';
import { Bed, Staff, HandoverNote } from './types';
import { Building2 } from 'lucide-react';
import { PatientRegister } from './components/patients/PatientRegister';

export default function App() {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [currentUser, setCurrentUser] = useState<string | null>(null);
  const [beds, setBeds] = useState<Bed[]>([]);
  const [staff, setStaff] = useState<Staff[]>([]);
  const [notes, setNotes] = useState<HandoverNote[]>([]);
  const [loading, setLoading] = useState(true);
  const [activeSection, setActiveSection] = useState('register');

  const fetchData = async () => {
    try {
      const [bedsRes, staffRes, notesRes] = await Promise.all([
        fetch('/api/beds'),
        fetch('/api/staff'),
        fetch('/api/notes')
      ]);
      
      const [bedsData, staffData, notesData] = await Promise.all([
        bedsRes.json(),
        staffRes.json(),
        notesRes.json()
      ]);

      setBeds(bedsData);
      setStaff(staffData);
      setNotes(notesData);
    } catch (error) {
      console.error('Failed to fetch data:', error);
    } finally {
      if (isAuthenticated) setLoading(false);
    }
  };

  useEffect(() => {
    if (isAuthenticated) {
      fetchData();
    } else {
      setLoading(false);
    }
  }, [isAuthenticated]);

  const handleLogin = (staffId: string) => {
    setIsAuthenticated(true);
    setCurrentUser(staffId);
    setLoading(true);
  };

  const handleLogout = () => {
    setIsAuthenticated(false);
    setCurrentUser(null);
  };

  const admitPatient = async () => {
    const availableBed = beds.find(b => b.status === 'available');
    if (!availableBed) {
      alert("No available beds!");
      return;
    }

    try {
      const randomPatientId = `p${Math.floor(Math.random() * 9) + 1}`; 
      await fetch(`/api/beds/${availableBed.id}/assign`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ patientId: randomPatientId }),
      });
      fetchData();
    } catch (e) {
      console.error(e);
    }
  };

  if (!isAuthenticated) return <LoginPage onLogin={handleLogin} />;

  if (loading) {
    return (
      <div className="h-screen w-screen flex items-center justify-center bg-brand-background text-brand-primary font-serif italic text-2xl">
        Loading Wellmeadows Management System...
      </div>
    );
  }

  const getHeaderTitle = () => {
    switch (activeSection) {
      case 'register': return 'REGISTER AND UPDATE PATIENT';
      case 'ward': return 'WARD & BED MANAGEMENT';
      case 'settings': return 'SYSTEM CONFIGURATION';
      default: return 'WELLMEADOWS PORTAL';
    }
  };

  return (
    <div className="flex h-screen overflow-hidden bg-brand-background font-sans selection:bg-brand-cyan/30">
      <Sidebar activeId={activeSection} onNavigate={setActiveSection} onLogout={handleLogout} />
      
      <main className="flex-1 flex flex-col overflow-hidden">
        <Header title={getHeaderTitle()} onAction={admitPatient} />
        
        <div className="flex-1 p-10 overflow-y-auto scrollbar-hide">
          <AnimatePresence mode="wait">
            {activeSection === 'register' && (
              <motion.div key="register">
                <PatientRegister />
              </motion.div>
            )}

            {activeSection === 'ward' && (
              <motion.div 
                key="ward"
                initial={{ opacity: 0, scale: 0.98 }}
                animate={{ opacity: 1, scale: 1 }}
                exit={{ opacity: 0, scale: 0.98 }}
                className="flex flex-col space-y-10"
              >
                <div className="flex items-center justify-between">
                   <h3 className="text-2xl font-bold text-brand-primary">Ward Overview</h3>
                   <div className="flex gap-4">
                      <div className="px-6 py-3 bg-white border border-brand-border rounded-2xl shadow-sm text-center">
                        <span className="block text-[8px] font-bold text-brand-muted uppercase mb-1">Available</span>
                        <span className="text-xl font-bold text-brand-cyan">{beds.filter(b => b.status === 'available').length}</span>
                      </div>
                      <div className="px-6 py-3 bg-brand-primary rounded-2xl shadow-lg text-center">
                        <span className="block text-[8px] font-bold text-white/50 uppercase mb-1">Occupied</span>
                        <span className="text-xl font-bold text-white">{beds.filter(b => b.status === 'occupied').length}</span>
                      </div>
                   </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
                  <div className="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-brand-border">
                    <BedGrid beds={beds} onRefresh={fetchData} />
                  </div>
                  <div className="space-y-10">
                    <StaffList staffList={staff} />
                    <WardStats 
                      occupancy={Math.round((beds.filter(b => b.status === 'occupied').length / (beds.length || 1)) * 100)}
                      avgStay={4.2}
                      efficiency="18/20"
                      notes={notes}
                    />
                  </div>
                </div>
              </motion.div>
            )}

            {['settings'].includes(activeSection) && (
              <motion.div 
                key={activeSection}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                className="flex flex-col items-center justify-center h-full text-brand-muted"
              >
                <Building2 className="w-16 h-16 mb-4 opacity-10" />
                <h3 className="text-sm font-bold uppercase tracking-widest">Section under development</h3>
                <p className="text-xs italic mt-2">Wellmeadows System v1.0.4</p>
              </motion.div>
            )}
          </AnimatePresence>
        </div>
      </main>
    </div>
  );
}

