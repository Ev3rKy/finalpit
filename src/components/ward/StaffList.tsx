import { Staff } from '../../types';

interface StaffListProps {
  staffList: Staff[];
}

export function StaffList({ staffList }: StaffListProps) {
  return (
    <section className="bg-brand-surface rounded-3xl p-6 shadow-sm border border-brand-border">
      <h2 className="text-md font-bold mb-4 flex items-center justify-between text-brand-text">
        On Duty <span className="text-xs text-brand-primary px-3 py-0.5 bg-brand-bg rounded-full font-bold">{staffList.length} Staff</span>
      </h2>
      <div className="space-y-4">
        {staffList.map((staff) => (
          <div key={staff.id} className="flex items-center gap-3">
            <div className={`w-9 h-9 rounded-full bg-brand-border border border-brand-primary overflow-hidden shadow-sm`}>
               <img 
                src={staff.avatar || `https://api.dicebear.com/7.x/avataaars/svg?seed=${staff.name}`} 
                alt={staff.name} 
                className="w-full h-full object-cover"
                referrerPolicy="no-referrer"
              />
            </div>
            <div className="flex-1">
              <p className="text-xs font-bold text-brand-text">{staff.name}</p>
              <p className="text-[10px] text-brand-muted font-medium">{staff.role}</p>
            </div>
            <div className={`w-2 h-2 rounded-full ${
              (staff.status === 'online' || staff.status === 'On Duty') ? 'bg-green-500' : 
              staff.status === 'busy' ? 'bg-amber-400' : 'bg-brand-muted'
            } shadow-sm animate-pulse`}></div>
          </div>
        ))}
      </div>
      <button className="w-full mt-6 py-2 border border-brand-border text-xs font-bold text-brand-text rounded-xl hover:bg-brand-bg transition-all active:scale-95 shadow-sm">
        View Full Rota
      </button>
    </section>
  );
}
