


<?php $__env->startSection('title', 'Formulir Keberatan - PPID'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Formulir Pengajuan Keberatan</h2>
               
            </div>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('keberatan.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-1-circle-fill me-2"></i>Nomor Registrasi Permohonan
                            </h5>
                            
                            <div class="mb-3">
                                <label for="nomor_registrasi_permohonan" class="form-label fw-bold">
                                    Nomor Registrasi Permohonan <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['nomor_registrasi_permohonan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="nomor_registrasi_permohonan" 
                                       name="nomor_registrasi_permohonan" 
                                       value="<?php echo e(old('nomor_registrasi_permohonan')); ?>" 
                                       placeholder="Contoh: PPID-202601-0001"
                                       required>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Masukkan nomor registrasi dari permohonan informasi yang ingin diajukan keberatan
                                </small>
                                <?php $__errorArgs = ['nomor_registrasi_permohonan'];
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
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-2-circle-fill me-2"></i>Data Pemohon
                            </h5>
                            
                            <div class="row">
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nama_pemohon" class="form-label fw-bold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['nama_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="nama_pemohon" 
                                           name="nama_pemohon" 
                                           value="<?php echo e(old('nama_pemohon')); ?>" 
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                    <?php $__errorArgs = ['nama_pemohon'];
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
                                    <label for="nomor_kontak" class="form-label fw-bold">
                                        Nomor Kontak <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['nomor_kontak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="nomor_kontak" 
                                           name="nomor_kontak" 
                                           value="<?php echo e(old('nomor_kontak')); ?>" 
                                           placeholder="Contoh: 08123456789"
                                           required>
                                    <?php $__errorArgs = ['nomor_kontak'];
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

                                
                                <div class="col-md-8 mb-3">
                                    <label for="alamat" class="form-label fw-bold">
                                        Alamat <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="alamat" 
                                              name="alamat" 
                                              rows="3" 
                                              placeholder="Masukkan alamat lengkap"
                                              required><?php echo e(old('alamat')); ?></textarea>
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

                                
                                <div class="col-md-4 mb-3">
                                    <label for="pekerjaan" class="form-label fw-bold">
                                        Pekerjaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['pekerjaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="pekerjaan" 
                                           name="pekerjaan" 
                                           value="<?php echo e(old('pekerjaan')); ?>" 
                                           placeholder="Contoh: Pegawai Swasta"
                                           required>
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
                                    <label for="kartu_identitas" class="form-label fw-bold">
                                        Upload Kartu Identitas <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" 
                                           class="form-control <?php $__errorArgs = ['kartu_identitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="kartu_identitas" 
                                           name="kartu_identitas" 
                                           accept=".pdf,.jpg,.jpeg,.png" 
                                           required>
                                    <small class="form-text text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Format: PDF, JPG, PNG (Max: 2MB) | KTP / KK / SIM / Paspor
                                    </small>
                                    <?php $__errorArgs = ['kartu_identitas'];
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
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-3-circle-fill me-2"></i>Rincian Informasi
                            </h5>

                            
                            <div class="mb-3">
                                <label for="informasi_diminta" class="form-label fw-bold">
                                    Informasi yang Diminta <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['informasi_diminta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="informasi_diminta" 
                                          name="informasi_diminta" 
                                          rows="4" 
                                          placeholder="Jelaskan secara rinci informasi apa yang Anda minta dalam permohonan sebelumnya"
                                          required><?php echo e(old('informasi_diminta')); ?></textarea>
                                <?php $__errorArgs = ['informasi_diminta'];
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
                                <label for="tujuan_penggunaan" class="form-label fw-bold">
                                    Tujuan Penggunaan Informasi <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['tujuan_penggunaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="tujuan_penggunaan" 
                                          name="tujuan_penggunaan" 
                                          rows="4" 
                                          placeholder="Jelaskan untuk apa informasi tersebut akan digunakan"
                                          required><?php echo e(old('tujuan_penggunaan')); ?></textarea>
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
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-4-circle-fill me-2"></i>Alasan Pengajuan Keberatan
                            </h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Pilih Alasan Keberatan (Pasal 35 ayat 1 UU KIP) <span class="text-danger">*</span>
                                </label>

                                <div class="list-group">
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" 
                                               type="radio" 
                                               name="alasan_keberatan" 
                                               value="penolakan_pasal_17"
                                               <?php echo e(old('alasan_keberatan') == 'penolakan_pasal_17' ? 'checked' : ''); ?>

                                               required>
                                        <strong>a.</strong> Penolakan berdasarkan alasan sebagaimana dimaksud dalam Pasal 17 UU KIP
                                    </label>
                                    
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" 
                                               type="radio" 
                                               name="alasan_keberatan" 
                                               value="tidak_disediakan_berkala"
                                               <?php echo e(old('alasan_keberatan') == 'tidak_disediakan_berkala' ? 'checked' : ''); ?>>
                                        <strong>b.</strong> Tidak disediakan informasi berkala
                                    </label>
                                    
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" 
                                               type="radio" 
                                               name="alasan_keberatan" 
                                               value="tidak_ditanggapi"
                                               <?php echo e(old('alasan_keberatan') == 'tidak_ditanggapi' ? 'checked' : ''); ?>>
                                        <strong>c.</strong> Tidak ditanggapinya permintaan informasi
                                    </label>
                                    
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" 
                                               type="radio" 
                                               name="alasan_keberatan" 
                                               value="tidak_sesuai_permintaan"
                                               <?php echo e(old('alasan_keberatan') == 'tidak_sesuai_permintaan' ? 'checked' : ''); ?>>
                                        <strong>d.</strong> Permintaan informasi tidak ditanggapi sebagaimana yang diminta
                                    </label>
                                    
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" 
                                               type="radio" 
                                               name="alasan_keberatan" 
                                               value="tidak_dipenuhi"
                                               <?php echo e(old('alasan_keberatan') == 'tidak_dipenuhi' ? 'checked' : ''); ?>>
                                        <strong>e.</strong> Tidak dipenuhinya permintaan informasi
                                    </label>
                                    
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" 
                                               type="radio" 
                                               name="alasan_keberatan" 
                                               value="biaya_tidak_wajar"
                                               <?php echo e(old('alasan_keberatan') == 'biaya_tidak_wajar' ? 'checked' : ''); ?>>
                                        <strong>f.</strong> Pengenaan biaya yang tidak wajar
                                    </label>
                                    
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" 
                                               type="radio" 
                                               name="alasan_keberatan" 
                                               value="melebihi_jangka_waktu"
                                               <?php echo e(old('alasan_keberatan') == 'melebihi_jangka_waktu' ? 'checked' : ''); ?>>
                                        <strong>g.</strong> Penyampaian informasi yang melebihi jangka waktu yang diatur dalam UU KIP
                                    </label>
                                </div>

                                <?php $__errorArgs = ['alasan_keberatan'];
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
                        </div>

                        <hr class="my-4">

                        
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-5-circle-fill me-2"></i>Uraian Keberatan
                            </h5>

                            <div class="mb-3">
                                <label for="uraian_keberatan" class="form-label fw-bold">
                                    Jelaskan Kasus Anda <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['uraian_keberatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="uraian_keberatan" 
                                          name="uraian_keberatan" 
                                          rows="6" 
                                          placeholder="Jelaskan secara detail kronologi dan alasan pengajuan keberatan Anda. Semakin lengkap penjelasan Anda, akan memudahkan proses penanganan keberatan."
                                          required><?php echo e(old('uraian_keberatan')); ?></textarea>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Jelaskan dengan lengkap dan jelas mengenai kasus keberatan Anda
                                </small>
                                <?php $__errorArgs = ['uraian_keberatan'];
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

                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send me-2"></i>Kirim Keberatan
                            </button>
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Informasi Penting
                    </h6>
                    <ul class="mb-0 small">
                        <li>Pastikan nomor registrasi permohonan yang Anda masukkan sudah benar</li>
                        <li>Isi semua field yang bertanda <span class="text-danger">*</span> (wajib)</li>
                        <li>Jelaskan alasan keberatan dengan lengkap dan jelas</li>
                        <li>Setelah mengirim, Anda akan mendapat nomor registrasi keberatan untuk tracking</li>
                        <li>Proses penanganan keberatan maksimal 30 hari kerja sesuai UU KIP</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.list-group-item {
    cursor: pointer;
    transition: all 0.3s;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.list-group-item input[type="radio"]:checked ~ * {
    font-weight: 600;
}

.list-group-item:has(input[type="radio"]:checked) {
    background-color: #e7f3ff;
    border-color: #0d6efd;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/keberatan/index.blade.php ENDPATH**/ ?>