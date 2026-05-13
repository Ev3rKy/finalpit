import { useState, useEffect } from 'react';
import { Search } from 'lucide-react';
import { motion } from 'motion/react';

interface Patient {
  id: string;
  name: string;
  priority: string;
  note: string;
  dob: string;
  marital_status: string;
  registered_at: string;
  type: string;
}

export function PatientRegister() {
  const [patients, setPatients] = useState<Patient[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchPatients = async () => {
      try {
        const response = await fetch('/api/patients');
        const data = await response.json();
        setPatients(data);
      } catch (error) {
        console.error('Failed to fetch patients:', error);
      } finally {
        setLoading(false);
      }
    };
    fetchPatients();
  }, []);

  const getInitials = (name: string) => {
    return name.split(' ').map(n => n[0]).join('').toUpperCase();
  };

  const stats = [
    { label: 'TOTAL PATIENTS', value: patients.length.toString(), sub: 'Active Patients', color: 'bg-brand-primary text-white' },
    { label: 'REGISTERED THIS MONTH', value: patients.filter(p => p.registered_at?.includes('May')).length.toString(), sub: 'New Referrals', color: 'bg-brand-cyan text-brand-primary' },
    { label: 'OUT-PATIENTS', value: patients.filter(p => p.type === 'OUT-PATIENT').length.toString(), sub: 'Clinic Appointment', color: 'bg-white border border-brand-border text-brand-primary' },
    { label: 'IN-PATIENTS', value: patients.filter(p => p.type === 'IN-PATIENT').length.toString(), sub: 'Currently Admitted', color: 'bg-white border-2 border-brand-cyan text-brand-primary' },
  ];

  if (loading) {
    return <div className="p-20 text-center font-serif italic text-brand-primary">Loading records...</div>;
  }

  return (
    <div className="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
      {/* Stat Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((card, i) => (
          <motion.div
            key={card.label}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: i * 0.1 }}
            className={`p-8 rounded-[2rem] shadow-sm flex flex-col ${card.color}`}
          >
            <span className="text-[10px] font-bold uppercase tracking-widest opacity-60 mb-4">{card.label}</span>
            <div className="flex flex-col">
              <span className="text-5xl font-bold mb-2">{card.value}</span>
              <span className="text-xs font-medium opacity-80">{card.sub}</span>
            </div>
          </motion.div>
        ))}
      </div>

      {/* Main Table Area */}
      <div className="bg-white rounded-[2rem] shadow-sm border border-brand-border overflow-hidden">
        <div className="p-8 flex items-center justify-between">
          <h3 className="text-xl font-bold text-brand-primary">Patient Register</h3>
          
          <div className="relative w-96">
            <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-brand-muted" />
            <input 
              type="text" 
              placeholder="Search by name, patient no, or date..."
              className="w-full bg-brand-background/30 border border-brand-border rounded-xl py-3 pl-12 pr-4 text-sm outline-none focus:border-brand-cyan transition-colors"
            />
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left">
            <thead>
              <tr className="border-b border-brand-background text-[10px] font-bold text-brand-muted uppercase tracking-[0.1em]">
                <th className="px-8 py-4">PATIENT</th>
                <th className="px-8 py-4">PATIENT NO.</th>
                <th className="px-8 py-4">DOB</th>
                <th className="px-8 py-4">MARITAL STATUS</th>
                <th className="px-8 py-4">REGISTERED</th>
                <th className="px-8 py-4">STATUS</th>
                <th className="px-8 py-4 text-right">ACTIONS</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-brand-background">
              {patients.map((p) => (
                <tr key={p.id} className="group hover:bg-brand-background/20 transition-colors">
                  <td className="px-8 py-6">
                    <div className="flex items-center gap-4">
                      <div className="w-10 h-10 rounded-full bg-brand-primary flex items-center justify-center text-white text-xs font-bold shadow-sm">
                        {getInitials(p.name)}
                      </div>
                      <span className="text-sm font-bold text-brand-primary">{p.name}</span>
                    </div>
                  </td>
                  <td className="px-8 py-6 text-sm text-brand-muted font-medium">{p.id.toUpperCase()}</td>
                  <td className="px-8 py-6 text-sm text-brand-muted font-medium">{p.dob}</td>
                  <td className="px-8 py-6 text-sm text-brand-muted font-medium">{p.marital_status}</td>
                  <td className="px-8 py-6 text-sm text-brand-muted font-medium">{p.registered_at}</td>
                  <td className="px-8 py-6">
                    <span className={`px-4 py-1.5 rounded-full text-[10px] font-bold tracking-wider ${
                      p.type === 'IN-PATIENT' 
                        ? 'bg-green-100 text-green-700' 
                        : 'bg-orange-100 text-orange-700'
                    }`}>
                      {p.type}
                    </span>
                  </td>
                  <td className="px-8 py-6 text-right">
                    <div className="flex items-center justify-end gap-3">
                      <button className="text-[10px] font-bold text-brand-primary hover:underline">Edit â†’</button>
                      <button className="text-[10px] font-bold text-brand-cyan hover:underline">Records â†’</button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}

