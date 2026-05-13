export type BedStatus = 'occupied' | 'available' | 'cleaning';

export interface Patient {
  id: string;
  name: string;
  priority: 'low' | 'medium' | 'high';
  note: string;
}

export interface Bed {
  id: string;
  label: string;
  status: BedStatus;
  patient?: Patient;
}

export interface Staff {
  id: string;
  name: string;
  role: string;
  status: string;
  avatar?: string;
}

export interface HandoverNote {
  id: string;
  author: string;
  content: string;
  time: string;
}
