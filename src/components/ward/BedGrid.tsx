import { BedCard } from './BedCard';
import { Bed } from '../../types';

interface BedGridProps {
  beds: Bed[];
  onRefresh: () => void;
}

export function BedGrid({ beds, onRefresh }: BedGridProps) {
  return (
    <div className="flex flex-col h-full">
      <div className="flex items-center justify-between mb-6">
        <h2 className="text-lg font-semibold text-brand-text">Real-time Bed Status</h2>
        <div className="flex gap-2 flex-wrap justify-end">
          <StatusLegend color="bg-brand-secondary" label="Occupied" />
          <StatusLegend color="bg-brand-accent" label="Cleaning" />
          <StatusLegend color="bg-white border border-brand-border" label="Available" />
        </div>
      </div>

      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 overflow-y-auto pr-2 pb-4">
        {beds.map((bed) => (
          <div key={bed.id}>
            <BedCard bed={bed} onRefresh={onRefresh} />
          </div>
        ))}
      </div>
    </div>
  );
}

function StatusLegend({ color, label }: { color: string; label: string }) {
  return (
    <span className="flex items-center gap-1.5 text-[10px] font-bold px-3 py-1 bg-white rounded-full border border-brand-border shadow-sm">
      <div className={`w-2 h-2 rounded-full ${color}`}></div> 
      {label}
    </span>
  );
}
