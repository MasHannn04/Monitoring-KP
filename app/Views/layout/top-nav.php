        <?php
            // Clean up titles for the Welcome message
            $clean_nama = preg_replace('/^(Bapak|Ibu|Mas|Mbak|Pak|Kak|Bang|Dr\.|Prof\.)\s+/i', '', $_SESSION['nama'] ?? 'User');

            // Evaluate if password is still default (same as NPM/NIP) if not yet set in session
            if (!isset($_SESSION['is_default_password']) && isset($_SESSION['user_id'])) {
                $db = \Config\Database::connect();
                $u_chk = $db->query("SELECT npm_nip, password FROM users WHERE id = " . (int)$_SESSION['user_id'])->getRowArray();
                $_SESSION['is_default_password'] = ($u_chk && password_verify($u_chk['npm_nip'], $u_chk['password']));
            }
        ?>
        <header class="topbar">
            <div style="display: flex; align-items: center;">
                <i class="fa-solid fa-bars mobile-toggle" onclick="toggleSidebar()"></i>
                <div class="mobile-title">SIM KP ITATS</div>
                <div class="topbar-left" style="margin-left: 15px;">Welcome <?= htmlspecialchars($clean_nama) ?> 👋</div>
            </div>
            
            <div class="topbar-right">
                <div class="user-dropdown" onclick="toggleDropdown()" style="cursor: pointer; position: relative;">
                    <div class="user-info-top">
                        <span class="name"><?= htmlspecialchars($clean_nama) ?> <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></span>
                        <span class="role"><?= ucfirst($_SESSION['role'] ?? '') ?></span>
                    </div>
                    <?php
                        $first_name = explode(' ', trim($clean_nama))[0];
                        $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($first_name) . "&background=EBF4FF&color=103F80";
                    ?>
                    <img src="<?= $avatar_url ?>" alt="Profile" style="width: 35px; border-radius: 50%;">
                    
                    <div id="logout-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.12); border: 1px solid var(--border-color); border-radius: 8px; padding: 6px; margin-top: 15px; z-index: 1000; min-width: 185px;">
                        <a href="javascript:void(0)" onclick="openModalGantiPassword()" style="color: #2b3a4a; text-decoration: none; font-size: 13.5px; display: flex; align-items: center; gap: 9px; padding: 9px 12px; border-radius: 6px; transition: all 0.2s; font-weight: 500;" onmouseover="this.style.backgroundColor='#F4F9FF'; this.style.color='#103F80';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2b3a4a';">
                            <i class="fa-solid fa-key" style="color: #103F80; width: 16px;"></i> Ganti Password
                            <?php if (!empty($_SESSION['is_default_password'])): ?>
                                <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #f59f00; margin-left: auto;" title="Disarankan ganti password"></span>
                            <?php endif; ?>
                        </a>
                        <div style="border-top: 1px solid #edf2f7; margin: 4px 0;"></div>
                        <a href="<?= base_url('logout') ?>" style="color: #dc3545; text-decoration: none; font-size: 13.5px; display: flex; align-items: center; gap: 9px; padding: 9px 12px; border-radius: 6px; transition: all 0.2s; font-weight: 500;" onmouseover="this.style.backgroundColor='#fff5f5'" onmouseout="this.style.backgroundColor='transparent'">
                            <i class="fa-solid fa-right-from-bracket" style="width: 16px;"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Modal Ganti Password Global -->
        <div id="modalGantiPassword" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 15px; box-sizing: border-box;">
            <div style="background: #ffffff; border-radius: 12px; max-width: 440px; width: 100%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.04); overflow: hidden;">
                <!-- Modal Header -->
                <div style="padding: 18px 24px; background: linear-gradient(135deg, #103F80 0%, #1a56a6 100%); color: white; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-key" style="font-size: 14px;"></i>
                        </div>
                        <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: white;">Ganti Password Akun</h3>
                    </div>
                    <button type="button" onclick="closeModalGantiPassword()" style="background: none; border: none; color: rgba(255,255,255,0.85); font-size: 22px; cursor: pointer; padding: 0 6px; line-height: 1;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='rgba(255,255,255,0.85)'">&times;</button>
                </div>

                <!-- Modal Body -->
                <div style="padding: 24px;">
                    <div id="alertGantiPassword" style="display: none; padding: 12px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 16px; line-height: 1.4;"></div>

                    <form id="formGantiPassword" onsubmit="submitGantiPassword(event)">
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Password Lama</label>
                            <div style="position: relative;">
                                <input type="password" id="input_pass_lama" name="password_lama" required placeholder="Masukkan password saat ini" style="width: 100%; padding: 10px 38px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#103F80'" onblur="this.style.borderColor='#cbd5e1'">
                                <i class="fa-solid fa-eye" onclick="togglePassVisibility('input_pass_lama', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94a3b8; font-size: 14px;"></i>
                            </div>
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Password Baru</label>
                            <div style="position: relative;">
                                <input type="password" id="input_pass_baru" name="password_baru" required minlength="6" placeholder="Minimal 6 karakter" style="width: 100%; padding: 10px 38px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#103F80'" onblur="this.style.borderColor='#cbd5e1'">
                                <i class="fa-solid fa-eye" onclick="togglePassVisibility('input_pass_baru', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94a3b8; font-size: 14px;"></i>
                            </div>
                            <small style="display: block; font-size: 11.5px; color: #64748b; margin-top: 4px;">Hindari menggunakan NPM/NIP kembali demi keamanan.</small>
                        </div>

                        <div style="margin-bottom: 22px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">Konfirmasi Password Baru</label>
                            <div style="position: relative;">
                                <input type="password" id="input_pass_konfirmasi" name="konfirmasi_password" required minlength="6" placeholder="Ketik ulang password baru" style="width: 100%; padding: 10px 38px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#103F80'" onblur="this.style.borderColor='#cbd5e1'">
                                <i class="fa-solid fa-eye" onclick="togglePassVisibility('input_pass_konfirmasi', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94a3b8; font-size: 14px;"></i>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" onclick="closeModalGantiPassword()" style="padding: 9px 16px; border: 1px solid #cbd5e1; background: #f8fafc; color: #475569; font-size: 13px; font-weight: 500; border-radius: 6px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">Batal</button>
                            <button type="submit" id="btnSubmitGantiPassword" style="padding: 9px 20px; border: none; background: #103F80; color: #ffffff; font-size: 13px; font-weight: 600; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='#0d3266'" onmouseout="this.style.background='#103F80'">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Password
                            </button>
                        </div>
                    </form>

                    <div style="margin-top: 18px; padding-top: 14px; border-top: 1px dashed #e2e8f0; font-size: 12px; color: #64748b; text-align: center; line-height: 1.4;">
                        <i class="fa-solid fa-circle-question" style="color: #103F80; margin-right: 4px;"></i> 
                        Lupa password lama Anda? Silakan hubungi <strong>Koordinator KP</strong> untuk bantuan reset password.
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleDropdown() {
                var menu = document.getElementById("logout-menu");
                if (menu.style.display === "none" || menu.style.display === "") {
                    menu.style.display = "block";
                } else {
                    menu.style.display = "none";
                }
            }

            function toggleSidebar() {
                document.querySelector('.sidebar').classList.toggle('open');
            }

            function openModalGantiPassword() {
                var menu = document.getElementById("logout-menu");
                if (menu) menu.style.display = "none";
                
                var modal = document.getElementById("modalGantiPassword");
                var alertBox = document.getElementById("alertGantiPassword");
                document.getElementById("formGantiPassword").reset();
                alertBox.style.display = "none";
                modal.style.display = "flex";
                document.getElementById("input_pass_lama").focus();
            }

            function closeModalGantiPassword() {
                var modal = document.getElementById("modalGantiPassword");
                if (modal) modal.style.display = "none";
            }

            function togglePassVisibility(inputId, icon) {
                var input = document.getElementById(inputId);
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }

            function submitGantiPassword(e) {
                e.preventDefault();
                var lama = document.getElementById("input_pass_lama").value;
                var baru = document.getElementById("input_pass_baru").value;
                var konfirmasi = document.getElementById("input_pass_konfirmasi").value;
                var alertBox = document.getElementById("alertGantiPassword");
                var btn = document.getElementById("btnSubmitGantiPassword");

                if (baru !== konfirmasi) {
                    alertBox.style.display = "block";
                    alertBox.style.background = "#fff5f5";
                    alertBox.style.color = "#c53030";
                    alertBox.style.border = "1px solid #feb2b2";
                    alertBox.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Konfirmasi password baru tidak cocok!';
                    return;
                }

                if (baru.length < 6) {
                    alertBox.style.display = "block";
                    alertBox.style.background = "#fff5f5";
                    alertBox.style.color = "#c53030";
                    alertBox.style.border = "1px solid #feb2b2";
                    alertBox.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Password baru minimal 6 karakter!';
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

                var formData = new FormData();
                formData.append("password_lama", lama);
                formData.append("password_baru", baru);
                formData.append("konfirmasi_password", konfirmasi);

                fetch("<?= base_url('ganti_password') ?>", {
                    method: "POST",
                    body: formData,
                    credentials: "same-origin",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Password';
                    alertBox.style.display = "block";
                    if (data.status === "success") {
                        alertBox.style.background = "#f0fff4";
                        alertBox.style.color = "#22543d";
                        alertBox.style.border = "1px solid #9ae6b4";
                        alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + data.message;
                        document.getElementById("formGantiPassword").reset();
                        setTimeout(function() {
                            window.location.reload();
                        }, 1200);
                    } else {
                        alertBox.style.background = "#fff5f5";
                        alertBox.style.color = "#c53030";
                        alertBox.style.border = "1px solid #feb2b2";
                        alertBox.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + data.message;
                    }
                })
                .catch(function(err) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Password';
                    alertBox.style.display = "block";
                    alertBox.style.background = "#fff5f5";
                    alertBox.style.color = "#c53030";
                    alertBox.style.border = "1px solid #feb2b2";
                    alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Terjadi kesalahan koneksi server.';
                });
            }

            // Close the dropdown or modal when clicking outside
            window.onclick = function(event) {
                var modal = document.getElementById("modalGantiPassword");
                if (event.target === modal) {
                    closeModalGantiPassword();
                }

                if (!event.target.closest('.user-dropdown')) {
                    var dropdowns = document.getElementById("logout-menu");
                    if (dropdowns && dropdowns.style.display === "block") {
                        dropdowns.style.display = "none";
                    }
                }
                
                // Close sidebar when clicking outside on mobile
                if (window.innerWidth <= 768) {
                    if (!event.target.closest('.sidebar') && !event.target.closest('.mobile-toggle')) {
                        var sidebar = document.querySelector('.sidebar');
                        if (sidebar && sidebar.classList.contains('open')) {
                            sidebar.classList.remove('open');
                        }
                    }
                }
            }
        </script>
