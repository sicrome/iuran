@extends('layouts.app')

@section('title', 'Export Laporan - Kas RT')
@section('page-title', 'Export Laporan')

@section('content')
<div class="card">
    <div class="card-title">📥 Export Laporan</div>
    
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div style="background: #f8f9fa; padding: 20px; border-radius: 15px; text-align: center;">
            <div style="font-size: 40px; margin-bottom: 10px;">📊</div>
            <h4>Laporan Keuangan</h4>
            <p>Export laporan pemasukan dan pengeluaran</p>
            <a href="{{ route('laporan.keuangan') }}" style="display: inline-block; background: #667eea; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Export →</a>
        </div>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 15px; text-align: center;">
            <div style="font-size: 40px; margin-bottom: 10px;">📋</div>
            <h4>Laporan Iuran</h4>
            <p>Export laporan iuran warga</p>
            <a href="{{ route('laporan.iuran') }}" style="display: inline-block; background: #667eea; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Export →</a>
        </div>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 15px; text-align: center;">
            <div style="font-size: 40px; margin-bottom: 10px;">📒</div>
            <h4>Buku Kas</h4>
            <p>Export laporan buku kas</p>
            <a href="{{ route('laporan.kas') }}" style="display: inline-block; background: #667eea; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Export →</a>
        </div>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 15px; text-align: center;">
            <div style="font-size: 40px; margin-bottom: 10px;">📑</div>
            <h4>Semua Laporan</h4>
            <p>Export semua laporan dalam satu file</p>
            <button style="background: #28a745; color: white; padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer;">Coming Soon</button>
        </div>
    </div>
</div>
@endsection