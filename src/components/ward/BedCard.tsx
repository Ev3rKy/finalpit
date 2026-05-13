import { motion } from 'motion/react';
import { Bed } from '../../types';

interface BedCardProps {
  bed: Bed;
  onRefresh: () => void;
}

export function BedCard({ bed, onRefresh }: BedCardProps) {
  const updateStatus = async (newStatus: Bed['status']) => {
    try {
      await fetch(`/api/beds/${bed.id}/status`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: newStatus }),
      });
      onRefresh();
    } catch (e) {
      console.error(e);
    }
  };

  const getStatusStyles = () => {
    switch (bed.status) {
      case 'occupied':
        return 'border-brand-secondary';
      case 'cleaning':
        return 'border-brand-accent';
      case 'available':
        return 'border-brand-border border-dashed border-2 bg-transparent';
      default:
        return 'border-brand-border';
    }
  };

  if (bed.status === 'available') {
    return (
      <motion.div 
        whileHover={{ scale: 1.02 }}
        className={`p-4 rounded-2xl flex flex-col items-center justify-center text-center h-full min-h-[120px] relative group ${getStatusStyles()}`}
      >
        <div className="text-xs text-brand-muted mb-1 uppercase tracking-tight font-medium">Bed {bed.label}</div>
        <div className="text-sm text-brand-muted italic">Available</div>
        <button 
          onClick={() => updateStatus('cleaning')}
          className="absolute inset-0 opacity-0 group-hover:opacity-100 bg-brand-primary/10 flex items-center justify-center transition-opacity rounded-2xl text-[10px] uppercase font-bold text-brand-primary backdrop-blur-[1px]"
        >
          Send for Cleaning
        </button>
      </motion.div>
    );
  }

  return (
    <motion.div 
      whileHover={{ y: -4 }}
      className={`bg-brand-surface p-4 rounded-2xl border-b-4 shadow-sm h-full relative group transition-all ${getStatusStyles()}`}
    >
      <div className="text-xs text-brand-muted mb-1 uppercase tracking-tight font-medium">Bed {bed.label}</div>
      <div className={`font-medium mb-3 ${bed.status === 'cleaning' ? 'opacity-50 italic' : ''}`}>
        {bed.patient?.name || (bed.status === 'cleaning' ? 'Deep Clean' : 'Unknown')}
      </div>
      
      {bed.status === 'occupied' && bed.patient && (
        <div className="text-[10px] bg-brand-bg p-2 rounded-lg text-brand-primary font-medium leading-tight">
          <span className="uppercase text-[9px] block mb-0.5 opacity-70">
            {bed.patient.priority} Priority
          </span>
          {bed.patient.note}
        </div>
      )}

      {bed.status === 'cleaning' && (
        <div className="text-[10px] bg-amber-50 p-2 rounded-lg text-amber-700 font-medium">
          Scheduled sanitation in progress
        </div>
      )}

      <div className="absolute top-2 right-2 opacity-0 group-hover:opacity-100 flex gap-1 z-10">
        {bed.status === 'cleaning' && (
          <button 
            onClick={() => updateStatus('available')}
            className="p-1 px-2 bg-brand-secondary text-white text-[8px] font-bold rounded uppercase hover:scale-105 active:scale-95 transition-all"
          >
            Finish
          </button>
        )}
        {bed.status === 'occupied' && (
          <button 
            onClick={() => updateStatus('available')}
            className="p-1 px-2 bg-brand-primary text-white text-[8px] font-bold rounded uppercase hover:scale-105 active:scale-95 transition-all"
          >
            Discharge
          </button>
        )}
      </div>
    </motion.div>
  );
}
