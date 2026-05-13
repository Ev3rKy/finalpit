import React, { useState } from 'react';
import { motion } from 'motion/react';
import { Building2, Lock, User, ShieldCheck } from 'lucide-react';

interface LoginPageProps {
  onLogin: (staffId: string) => void;
}

export function LoginPage({ onLogin }: LoginPageProps) {
  const [staffId, setStaffId] = useState('');
  const [password, setPassword] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState('');

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    setError('');

    // Mock authentication delay
    setTimeout(() => {
      if (staffId && password) {
        onLogin(staffId);
      } else {
        setError('Please enter both Staff ID and password.');
        setIsLoading(false);
      }
    }, 1200);
  };

  return (
    <div className="min-h-screen w-full bg-brand-background flex items-center justify-center p-6 font-sans">
      <motion.div 
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="w-full max-w-md"
      >
        <div className="bg-white/40 backdrop-blur-xl border border-white/40 rounded-[2.5rem] shadow-2xl p-10 relative overflow-hidden">
          {/* Decorative elements */}
          <div className="absolute -top-24 -right-24 w-48 h-48 bg-brand-cyan/20 rounded-full blur-3xl" />
          <div className="absolute -bottom-24 -left-24 w-48 h-48 bg-brand-primary/10 rounded-full blur-3xl" />

          <div className="relative z-10">
            {/* Header */}
            <div className="flex flex-col items-center mb-10">
              <div className="flex items-center gap-1 text-3xl font-bold tracking-tight mb-1">
                <span className="text-brand-primary">Well</span>
                <span className="text-brand-cyan">meadows</span>
              </div>
              <p className="text-[10px] uppercase tracking-[0.2em] text-brand-primary/60 font-bold">Staff Portal Access</p>
            </div>

            {/* Form */}
            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="space-y-2">
                <label className="text-[10px] font-bold uppercase tracking-widest text-brand-primary/60 ml-1">Staff Identifier</label>
                <div className="relative group">
                  <User className="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-brand-primary/40 group-focus-within:text-brand-primary transition-colors" />
                  <input 
                    type="text" 
                    value={staffId}
                    onChange={(e) => setStaffId(e.target.value)}
                    placeholder="Enter Staff ID"
                    className="w-full bg-white/50 border border-white/60 focus:border-brand-primary/40 focus:bg-white rounded-2xl py-3.5 pl-12 pr-4 text-sm font-medium outline-none transition-all"
                  />
                </div>
              </div>

              <div className="space-y-2">
                <label className="text-[10px] font-bold uppercase tracking-widest text-brand-primary/60 ml-1">Secure Password</label>
                <div className="relative group">
                  <Lock className="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-brand-primary/40 group-focus-within:text-brand-primary transition-colors" />
                  <input 
                    type="password" 
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    placeholder="••••••••"
                    className="w-full bg-white/50 border border-white/60 focus:border-brand-primary/40 focus:bg-white rounded-2xl py-3.5 pl-12 pr-4 text-sm font-medium outline-none transition-all"
                  />
                </div>
              </div>

              {error && (
                <motion.p 
                  initial={{ opacity: 0, x: -10 }}
                  animate={{ opacity: 1, x: 0 }}
                  className="text-[10px] font-bold text-red-600 bg-red-50 p-3 rounded-xl border border-red-100"
                >
                  {error}
                </motion.p>
              )}

              <button 
                type="submit"
                disabled={isLoading}
                className="w-full bg-brand-primary text-white py-4 rounded-2xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-brand-primary/20 hover:opacity-95 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
              >
                {isLoading ? (
                  <div className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin" />
                ) : (
                  <>
                    <ShieldCheck className="w-4 h-4" />
                    Sign Into Portal
                  </>
                )}
              </button>
            </form>

            <div className="mt-10 text-center">
              <p className="text-[10px] text-brand-primary/40 font-medium">
                Internal system for authorized personnel only. 
                <br />
                IP access is logged for security audits.
              </p>
            </div>
          </div>
        </div>
      </motion.div>
    </div>
  );
}
