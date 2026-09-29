<?php if (!empty($_SESSION['is_default_password'])): ?>
<div id="default-password-alert" style="background: linear-gradient(135deg, #fff9db 0%, #fff3bf 100%); border: 1px solid #ffe066; border-left: 5px solid #f59f00; padding: 16px 20px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); flex-wrap: wrap;">
    <div style="display: flex; align-items: center; gap: 14px; flex: 1; min-width: 280px;">
        <div style="width: 42px; height: 42px; border-radius: 50%; background-color: #ffe066; color: #d9480f; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div>
            <div style="font-weight: 700; color: #8c4300; font-size: 14px; margin-bottom: 3px;">
                <i class="fa-solid fa-triangle-exclamation"></i> Peringatan Keamanan Akun!
            </div>
            <div style="color: #663300; font-size: 13px; line-height: 1.4;">
                Password akun Anda saat ini <strong>masih menggunakan password default (sama dengan NPM/NIP)</strong>. Demi keamanan data dan akun Anda, disarankan untuk <strong>segera mengganti password</strong> baru.
            </div>
        </div>
    </div>
    <div>
        <button type="button" onclick="openModalGantiPassword()" style="background-color: #f59f00; border: none; color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px 18px; border-radius: 6px; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(245, 159, 0, 0.3); transition: all 0.2s;" onmouseover="this.style.backgroundColor='#e67700'" onmouseout="this.style.backgroundColor='#f59f00'">
            <i class="fa-solid fa-key"></i> Ganti Password Sekarang
        </button>
    </div>
</div>
<?php endif; ?>
