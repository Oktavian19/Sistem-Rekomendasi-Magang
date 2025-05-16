@section('title', 'Detail Lowongan | Sistem Rekomendasi Magang')

@extends('layouts.app')

@section('content')
<section>
    <div class="container card" style="padding: 50px">
        <div class="row">
            <div class="col-lg-8 pe-lg-6">
                <div class="row justify-content-between align-items-center mb-4">
                    <div class="col-xl-8 col-xxl-6">
                        <div class="mb-3">
                            <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                 class="rounded" style="width:80px; height:80px" alt="Company Logo">
                        </div>
                        <h2 class="fw-bold">ERP Functional Consultant</h2>
                        <div class="mb-3">
                            <a href="https://diploy.id/companies/192" class="text-decoration-none">PT. Berca Hardayaperkasa</a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center mt-3">
                            <button type="submit" class="btn btn-primary ms-2 rounded-pill" data-bs-target="#needLogin" data-bs-toggle="modal">Daftar</button>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-between align-items-center mb-4">
                    <div class="col-auto mb-2">
                        <div>
                            <p class="text-muted mb-1">Total Pelamar</p>
                            <span class="fw-bold">1 orang</span>
                        </div>
                    </div>
                    <div class="col-auto mb-2">
                        <div>
                            <p class="text-muted mb-1">Pendaftaran</p>
                            <span class="fw-bold text-success">13 May</span> - <span class="fw-bold text-danger">01 Jun 2025</span>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="job-description mt-4">
                    <h4 class="mb-3">Deskripsi</h4>
                    <div class="text-muted">
                        <p><strong>Job Description:</strong></p>
                        <p>- Involved in the project as a team member to deliver the ERP implementation<br>
                        - Able to carry out ERP exploration according to the given stream task</p>
                        
                        <p><strong>Job Requirement:</strong></p>
                        <p>- Bachelor degree or Diploma from Accounting, Information System, Information Technology, Computer Science or related field<br>
                        - Minimum 1 year experience in the related field (Implementation ERP Functional Finance/HR Consultant) is advantage<br>
                        - Good Knowledge in ERP is advantage<br>
                        - Microsoft Office is a must<br>
                        - Excellent communication skills, smart and hard worker<br>
                        - Fast learner and hands-on executor with a positive attitude.<br>
                        - English speaking and writing skills are an advantage<br>
                        - Willing to travel out to town/country</p>
                    </div>
                    
                    <div class="alert alert-warning d-flex align-items-center mt-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                        <div>
                            <strong>Penting: Pendaftaran dan proses rekrutmen oleh perusahaan mitra Diploy sepenuhnya gratis dan tidak dipungut biaya dalam bentuk apa pun. Harap berhati-hati terhadap segala bentuk penipuan yang mengatasnamakan Diploy atau mitra kami. Segala proses rekrutmen/seleksi yang dilakukan di luar platform menjadi tanggung jawab penuh pengguna.</strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 ps-lg-6">
                <div class="card border border-primary mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-muted small">Bidang Pekerjaan</div>
                            <div class="fw-bold">Konsultan</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Lokasi</div>
                            <div class="fw-bold">Jakarta Pusat</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Kuota Pelamar</div>
                            <div class="fw-bold">5</div>
                        </div>
                    </div>
                </div>
                
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         class="rounded mb-2" style="width:80px; height:80px" alt="Company Logo">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <div class="fw-bold fs-5">82</div>
                                    <div class="text-muted small">Lowongan</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="fw-bold">PT. Berca Hardayaperkasa</h5>
                            <p class="text-muted small">Jakarta Pusat</p>
                        </div>
                        
                        <hr>
                        <div class="mb-3">
                            <div class="text-muted small">Email</div>
                            <div class="fw-bold">berca@contact.com</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Industri</div>
                            <div class="fw-bold">IT & Telecommunication</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Jml. Karyawan</div>
                            <div class="fw-bold">51-100</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection