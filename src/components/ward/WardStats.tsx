import { HandoverNote } from '../../types';

interface WardStatsProps {
  occupancy: number;
  avgStay: number;
  efficiency: string;
  notes: HandoverNote[];
}

export function WardStats({ occupancy, avgStay, efficiency, notes }: WardStatsProps) {
  return (
    <div className="flex flex-col gap-6 h-full">
      <div className="bg-white/60 p-6 rounded-3xl border border-brand-border backdrop-blur-sm shadow-sm">
        <h3 className="text-xs font-bold uppercase tracking-widest text-brand-muted mb-6">Ward Efficiency Metrics</h3>
        <div className="grid grid-cols-3 gap-6">
          <div className="border-r border-brand-border pr-2">
            <div className="text-3xl font-serif text-brand-primary font-bold">{occupancy}%</div>
            <div className="text-[10px] text-brand-muted font-bold uppercase">Current Occupancy</div>
          </div>
          <div className="border-r border-brand-border pr-2">
            <div className="text-3xl font-serif text-brand-primary font-bold">{avgStay}</div>
            <div className="text-[10px] text-brand-muted font-bold uppercase">Avg Days Stay</div>
          </div>
          <div>
            <div className="text-3xl font-serif text-brand-secondary font-bold">{efficiency}</div>
            <div className="text-[10px] text-brand-muted font-bold uppercase">Staff Efficiency</div>
          </div>
        </div>
      </div>

      <section className="bg-brand-primary text-white rounded-3xl p-6 shadow-lg flex-1 overflow-hidden flex flex-col">
        <h2 className="text-md font-bold mb-4">Shift Handover Notes</h2>
        <div className="space-y-3 overflow-y-auto pr-1">
          {notes.map((note) => (
            <div key={note.id} className="p-3 bg-white/10 rounded-xl border border-white/10 backdrop-blur-sm transition-transform hover:scale-[1.01]">
              <p className="text-[11px] leading-relaxed italic text-white/90">"{note.content}"</p>
              <p className="text-[9px] mt-2 text-white/60 text-right font-medium">— {note.author} • {note.time}</p>
            </div>
          ))}
        </div>
      </section>
    </div>
  );
}
