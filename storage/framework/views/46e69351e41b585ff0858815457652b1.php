

<?php $__env->startSection('title', 'Permohonan Informasi - PPID'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .kategori-option {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0;
    }
    
    .kategori-option:hover {
        border-color: #0e5b73;
        background-color: #f0f8ff;
    }
    
    .kategori-option.active {
        border-color: #0e5b73;
        background-color: #e6f3f8;
    }
    
    .kategori-option input[type="radio"] {
        display: none;
    }
    
    .dynamic-fields {
        display: none;
        animation: fadeIn 0.5s;
    }
    
    .dynamic-fields.show {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .required-badge {
        background-color: #dc3545;
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 3px;
        margin-left: 5px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <h2 class="mb-4 fw-bold">Formulir Permohonan Informasi</h2>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('permohonan.store')); ?>" method="POST" enctype="multipart/form-data" id="formPermohonan">
                        <?php echo csrf_field(); ?>
                        
                        
                        <div class="mb-5">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-person-badge me-2"></i>
                                Kategori Klasifikasi Pemohon
                                <span class="required-badge">WAJIB</span>
                            </h5>
                            
                            <div class="row g-3">
                                
                                <div class="col-md-4">
                                    <label class="kategori-option p-3 rounded text-center d-block">
                                        <input type="radio" name="kategori_pemohon" value="perorangan" 
                                               <?php echo e(old('kategori_pemohon') == 'perorangan' ? 'checked' : ''); ?> required>
                                        <i class="bi bi-person-circle fs-1 d-block text-primary mb-2"></i>
                                        <strong>Perorangan</strong>
                                        <small class="d-block text-muted">Individu/Perseorangan</small>
                                    </label>
                                </div>
                                
                                
                                <div class="col-md-4">
                                    <label class="kategori-option p-3 rounded text-center d-block">
                                        <input type="radio" name="kategori_pemohon" value="kelompok" 
                                               <?php echo e(old('kategori_pemohon') == 'kelompok' ? 'checked' : ''); ?> required>
                                        <i class="bi bi-people-fill fs-1 d-block text-success mb-2"></i>
                                        <strong>Kelompok Orang</strong>
                                        <small class="d-block text-muted">Organisasi/Komunitas</small>
                                    </label>
                                </div>
                                
                                
                                <div class="col-md-4">
                                    <label class="kategori-option p-3 rounded text-center d-block">
                                        <input type="radio" name="kategori_pemohon" value="badan_hukum" 
                                               <?php echo e(old('kategori_pemohon') == 'badan_hukum' ? 'checked' : ''); ?> required>
                                        <i class="bi bi-building fs-1 d-block text-warning mb-2"></i>
                                        <strong>Badan Hukum</strong>
                                        <small class="d-block text-muted">Perusahaan/Lembaga</small>
                                    </label>
                                </div>
                            </div>
                            
                            <?php $__errorArgs = ['kategori_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <hr class="my-4">

                        
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Data Pemohon
                            </h5>

                            <div class="row">
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" 
                                           class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('nama')); ?>" 
                                           placeholder="Masukkan nama lengkap" required>
                                    <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        Pekerjaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="pekerjaan" 
                                           class="form-control <?php $__errorArgs = ['pekerjaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('pekerjaan')); ?>" 
                                           placeholder="Contoh: PNS, Wiraswasta, Mahasiswa" required>
                                    <?php $__errorArgs = ['pekerjaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">
                                        Alamat Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="alamat" 
                                              class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              rows="3" 
                                              placeholder="Masukkan alamat lengkap termasuk RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi" required><?php echo e(old('alamat')); ?></textarea>
                                    <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        No. Telepon/HP <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="no_telepon" 
                                           class="form-control <?php $__errorArgs = ['no_telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('no_telepon')); ?>" 
                                           placeholder="Contoh: 08123456789" required>
                                    <?php $__errorArgs = ['no_telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" 
                                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('email')); ?>" 
                                           placeholder="contoh@email.com" required>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-file-text me-2"></i>
                                Rincian Permohonan Informasi
                            </h5>

                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Rincian Informasi yang Dibutuhkan <span class="text-danger">*</span>
                                </label>
                                <textarea name="rincian_informasi" 
                                          class="form-control <?php $__errorArgs = ['rincian_informasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          rows="4" 
                                          placeholder="Jelaskan secara detail dan spesifik informasi apa yang Anda butuhkan..." required><?php echo e(old('rincian_informasi')); ?></textarea>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Jelaskan informasi yang Anda butuhkan dengan jelas dan spesifik
                                </small>
                                <?php $__errorArgs = ['rincian_informasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Tujuan Penggunaan Informasi <span class="text-danger">*</span>
                                </label>
                                <textarea name="tujuan_penggunaan" 
                                          class="form-control <?php $__errorArgs = ['tujuan_penggunaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          rows="4" 
                                          placeholder="Jelaskan untuk apa informasi ini akan digunakan..." required><?php echo e(old('tujuan_penggunaan')); ?></textarea>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Jelaskan tujuan dan penggunaan informasi yang dimohonkan
                                </small>
                                <?php $__errorArgs = ['tujuan_penggunaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <hr class="my-4">

                        
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-file-earmark-arrow-up me-2"></i>
                                Dokumen Kelengkapan
                            </h5>

                            
                            <div id="fields-perorangan" class="dynamic-fields">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Dokumen untuk Perorangan:</strong> KTP, Paspor, atau SIM
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Jenis Kartu Identitas <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis_identitas" 
                                            class="form-select <?php $__errorArgs = ['jenis_identitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">-- Pilih Jenis Identitas --</option>
                                        <option value="KTP" <?php echo e(old('jenis_identitas') == 'KTP' ? 'selected' : ''); ?>>KTP</option>
                                        <option value="Paspor" <?php echo e(old('jenis_identitas') == 'Paspor' ? 'selected' : ''); ?>>Paspor</option>
                                        <option value="SIM" <?php echo e(old('jenis_identitas') == 'SIM' ? 'selected' : ''); ?>>SIM</option>
                                    </select>
                                    <?php $__errorArgs = ['jenis_identitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nomor Identitas <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nomor_identitas" 
                                           class="form-control <?php $__errorArgs = ['nomor_identitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('nomor_identitas')); ?>" 
                                           placeholder="Masukkan nomor identitas">
                                    <?php $__errorArgs = ['nomor_identitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload Kartu Identitas <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_identitas" 
                                           class="form-control <?php $__errorArgs = ['file_identitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                    <?php $__errorArgs = ['file_identitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div id="fields-kelompok" class="dynamic-fields">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Dokumen untuk Kelompok Orang:</strong> Surat Kuasa dan KTP Pemberi Kuasa
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nomor KTP Pemberi Kuasa <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nomor_ktp_pemberi_kuasa" 
                                           class="form-control <?php $__errorArgs = ['nomor_ktp_pemberi_kuasa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('nomor_ktp_pemberi_kuasa')); ?>" 
                                           placeholder="Masukkan nomor KTP pemberi kuasa">
                                    <?php $__errorArgs = ['nomor_ktp_pemberi_kuasa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload Surat Kuasa <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_surat_kuasa" 
                                           class="form-control <?php $__errorArgs = ['file_surat_kuasa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           accept=".pdf">
                                    <small class="form-text text-muted">Format: PDF (Max: 2MB)</small>
                                    <?php $__errorArgs = ['file_surat_kuasa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload KTP Pemberi Kuasa <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_ktp_pemberi_kuasa" 
                                           class="form-control <?php $__errorArgs = ['file_ktp_pemberi_kuasa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                    <?php $__errorArgs = ['file_ktp_pemberi_kuasa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div id="fields-badan_hukum" class="dynamic-fields">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Dokumen untuk Badan Hukum:</strong> Akta AHU dan AD/ART
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nomor Akta AHU Kementerian Hukum RI <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nomor_akta_ahu" 
                                           class="form-control <?php $__errorArgs = ['nomor_akta_ahu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('nomor_akta_ahu')); ?>" 
                                           placeholder="Masukkan nomor akta AHU">
                                    <?php $__errorArgs = ['nomor_akta_ahu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload Akta AHU Kementerian Hukum RI <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_akta_ahu" 
                                           class="form-control <?php $__errorArgs = ['file_akta_ahu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           accept=".pdf">
                                    <small class="form-text text-muted">Format: PDF (Max: 2MB)</small>
                                    <?php $__errorArgs = ['file_akta_ahu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload Anggaran Dasar/Anggaran Rumah Tangga (AD/ART) <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_ad_art" 
                                           class="form-control <?php $__errorArgs = ['file_ad_art'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           accept=".pdf">
                                    <small class="form-text text-muted">Format: PDF (Max: 2MB)</small>
                                    <?php $__errorArgs = ['file_ad_art'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        
                        <div class="mb-4">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Persetujuan dan Pernyataan
                                    </h6>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input <?php $__errorArgs = ['persetujuan_terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               type="checkbox" 
                                               name="persetujuan_terms" 
                                               id="persetujuan_terms" 
                                               value="1"
                                               <?php echo e(old('persetujuan_terms') ? 'checked' : ''); ?> 
                                               required>
                                        <label class="form-check-label" for="persetujuan_terms">
                                            Saya menyatakan bahwa informasi yang diperoleh <strong>tidak akan disalahgunakan</strong> 
                                            dan <strong>hanya digunakan sebagaimana mestinya</strong> sesuai dengan tujuan yang telah saya sampaikan. 
                                            Saya memahami dan bertanggung jawab penuh atas penggunaan informasi yang diberikan.
                                        </label>
                                        <?php $__errorArgs = ['persetujuan_terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>
                <h6 class="alert-heading mb-1">Berhasil!</h6>
                <p class="mb-0"><?php echo e(session('success')); ?></p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
            <div>
                <h6 class="alert-heading mb-1">Gagal!</h6>
                <p class="mb-0"><?php echo e(session('error')); ?></p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-exclamation-octagon-fill fs-4 me-3"></i>
            <div class="flex-grow-1">
                <h6 class="alert-heading mb-2">Terdapat Kesalahan Validasi:</h6>
                <ul class="mb-0 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send-fill me-2"></i>
                                Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h6 class="card-title fw-bold">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Informasi Penting
                    </h6>
                    <hr>
                    <ul class="small mb-0">
                        <li class="mb-2">Pilih kategori pemohon sesuai dengan status Anda</li>
                        <li class="mb-2">Isi semua field yang ditandai dengan (<span class="text-danger">*</span>)</li>
                        <li class="mb-2">Pastikan dokumen yang diupload jelas dan terbaca</li>
                        <li class="mb-2">Setelah mengirim, Anda akan mendapat nomor registrasi</li>
                        <li class="mb-2">Gunakan nomor registrasi untuk mengecek status permohonan</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title fw-bold">
                        <i class="bi bi-clock-fill text-success me-2"></i>
                        Waktu Proses
                    </h6>
                    <hr>
                    <p class="small mb-0">
                        Permohonan akan diproses maksimal <strong>10 hari kerja</strong> 
                        sesuai dengan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriOptions = document.querySelectorAll('.kategori-option');
    const kategoriRadios = document.querySelectorAll('input[name="kategori_pemohon"]');
    
    // Function to show/hide dynamic fields
    function updateDynamicFields() {
        const selectedKategori = document.querySelector('input[name="kategori_pemohon"]:checked');
        
        // Hide all dynamic fields first
        document.querySelectorAll('.dynamic-fields').forEach(field => {
            field.classList.remove('show');
            // Disable inputs in hidden fields
            field.querySelectorAll('input, select, textarea').forEach(input => {
                input.removeAttribute('required');
            });
        });
        
        if (selectedKategori) {
            const kategori = selectedKategori.value;
            const targetFields = document.getElementById(`fields-${kategori}`);
            
            if (targetFields) {
                targetFields.classList.add('show');
                // Enable inputs in visible fields
                targetFields.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.closest('.mb-3').querySelector('label').textContent.includes('*')) {
                        input.setAttribute('required', 'required');
                    }
                });
            }
        }
    }
    
    // Handle kategori selection visual feedback
    kategoriOptions.forEach(option => {
        option.addEventListener('click', function() {
            kategoriOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                updateDynamicFields();
            }
        });
    });
    
    // Handle radio change
    kategoriRadios.forEach(radio => {
        radio.addEventListener('change', updateDynamicFields);
    });
    
    // Initialize on page load (untuk handle old() values)
    const checkedRadio = document.querySelector('input[name="kategori_pemohon"]:checked');
    if (checkedRadio) {
        const parentLabel = checkedRadio.closest('.kategori-option');
        if (parentLabel) {
            parentLabel.classList.add('active');
        }
        updateDynamicFields();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/permohonan/index.blade.php ENDPATH**/ ?>