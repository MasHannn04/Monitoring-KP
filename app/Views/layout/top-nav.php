        <?php
            // Clean up titles for the Welcome message
            $clean_nama = preg_replace('/^(Bapak|Ibu|Mas|Mbak|Pak|Kak|Bang|Dr\.|Prof\.)\s+/i', '', $_SESSION['nama']);
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
                        <span class="role"><?= ucfirst($_SESSION['role']) ?></span>
                    </div>
                    <?php
                        $first_name = explode(' ', trim($clean_nama))[0];
                        $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($first_name) . "&background=EBF4FF&color=103F80";
                    ?>
                    <img src="<?= $avatar_url ?>" alt="Profile" style="width: 35px; border-radius: 50%;">
                    
                    <div id="logout-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid var(--border-color); border-radius: 6px; padding: 5px; margin-top: 15px; z-index: 1000; min-width: 150px;">
                        <a href="<?= base_url('logout') ?>" style="color: #dc3545; text-decoration: none; font-size: 14px; display: block; padding: 8px 12px; border-radius: 4px; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f8d7da'" onmouseout="this.style.backgroundColor='transparent'"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </div>
            </div>
        </header>

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

            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
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
                        if (sidebar.classList.contains('open')) {
                            sidebar.classList.remove('open');
                        }
                    }
                }
            }
        </script>
