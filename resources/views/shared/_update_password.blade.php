<!-- Modal -->
<div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ url('/' . strtolower(session('user.role') . '/change-password')) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Password harus terdiri dari minimal 6 karakter, kombinasi huruf dan angka.</p>
                    <div class="form-group">
                        <label for="passwordBaru">Password Baru</label>
                        <div class="input-group input-group-password @error('password_baru') is-invalid @enderror">
                            <input type="password" name="password_baru" id="passwordBaru" class="form-control" placeholder="Buat password">
                            <div class="input-group-append">
                                <button tabindex="-1" class="btn btn-outline-light" type="button">lihat</button>
                            </div>
                            @if($errors->has('password_baru'))
                            <div class="invalid-feedback text-right">
                                {{ $errors->first('password_baru') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="konfirmasiPassword">Konfirmasi Password</label>
                        <div class="input-group input-group-password">
                            <input type="password" name="confirm_password" id="konfirmasiPassword" class="form-control" placeholder="Konfirmasi password baru">
                            <div class="input-group-append">
                                <button tabindex="-1" class="btn btn-outline-light" type="button">lihat</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>