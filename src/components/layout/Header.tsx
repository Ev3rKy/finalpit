import { Plus } from 'lucide-react';

interface HeaderProps {
  title?: string;
  onAction?: () => void;
}

export function Header({ title = 'REGISTER AND UPDATE PATIENT', onAction }: HeaderProps) {
  const now = new Date();
  
  return (
    <header className="h-16 bg-brand-primary px-10 flex items-center justify-between sticky top-0 z-20 shadow-md">
      <h2 className="text-sm font-bold text-white uppercase tracking-[0.2em]">
        {title}
      </h2>
      
      <div className="flex items-center gap-8">
        <span className="text-xs font-semibold text-white/50 tracking-wider">
          {now.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })}
        </span>
        
        <button 
          onClick={onAction}
          className="flex items-center gap-2 bg-brand-cyan hover:bg-brand-cyan/90 text-brand-primary px-4 py-2 rounded-lg text-xs font-bold transition-all active:scale-95 shadow-lg shadow-brand-cyan/20"
        >
          <Plus className="w-4 h-4" />
          <span>New Patient</span>
        </button>
      </div>
    </header>
  );
}
