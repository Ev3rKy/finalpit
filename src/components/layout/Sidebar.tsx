import { LayoutGrid, Users, FileText, Calendar, Building2, LogOut, UserPlus, Bed, Settings } from 'lucide-react';
import { motion } from 'motion/react';

const navGroups = [
  {
    title: 'PATIENT MANAGEMENT',
    items: [
      { id: 'register', label: 'Patient Register', icon: UserPlus },
      { id: 'ward', label: 'Ward & Bed', icon: Bed },
    ]
  },
  {
    title: 'SYSTEM',
    items: [
      { id: 'settings', label: 'Settings', icon: Settings },
    ]
  }
];

interface SidebarProps {
  activeId?: string;
  onNavigate?: (id: string) => void;
  onLogout: () => void;
}

export function Sidebar({ activeId = 'register', onNavigate, onLogout }: SidebarProps) {
  return (
    <aside className="w-72 bg-brand-primary flex flex-col h-screen sticky top-0 overflow-hidden" id="sidebar">
      {/* Logo Area */}
      <div className="p-8 mb-4">
        <div className="flex items-center gap-1 text-2xl font-bold tracking-tight">
          <span className="text-white">Well</span>
          <span className="text-brand-cyan">meadows</span>
        </div>
      </div>
      
      {/* Nav Content */}
      <nav className="flex-1 px-4 overflow-y-auto">
        {navGroups.map((group) => (
          <div key={group.title} className="mb-8">
            <h3 className="px-4 text-[10px] font-bold text-brand-muted uppercase tracking-[0.15em] mb-4">
              {group.title}
            </h3>
            <div className="space-y-1">
              {group.items.map((item) => {
                const isActive = activeId === item.id;
                return (
                  <button
                    key={item.id}
                    onClick={() => onNavigate?.(item.id)}
                    className={`w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all relative group ${
                      isActive 
                        ? 'text-white bg-white/5' 
                        : 'text-brand-muted hover:text-white hover:bg-white/5'
                    }`}
                  >
                    {isActive && (
                      <motion.div 
                        layoutId="sidebar-active"
                        className="absolute left-0 top-3 bottom-3 w-1 bg-brand-cyan rounded-r-full"
                      />
                    )}
                    <item.icon className={`w-5 h-5 ${isActive ? 'text-brand-cyan' : 'group-hover:text-brand-cyan'} transition-colors`} />
                    <span className="font-semibold text-sm">{item.label}</span>
                  </button>
                );
              })}
            </div>
          </div>
        ))}
      </nav>

      {/* Footer / Out */}
      <div className="p-6 border-t border-white/5">
        <button 
          onClick={onLogout}
          className="w-full flex items-center gap-3 px-4 py-3 text-brand-muted hover:text-white transition-all group mb-4"
        >
          <LogOut className="w-5 h-5" />
          <span className="font-semibold text-sm">Sign Out</span>
        </button>

        <div className="px-4 py-2">
          <p className="text-[10px] text-brand-muted font-medium uppercase tracking-widest">Wellmeadows v1.0</p>
        </div>
      </div>
    </aside>
  );
}
