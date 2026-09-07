        <footer class="footer">
            Copyright <?= date('Y') ?> &copy; Institut Teknologi Adhi Tama Surabaya
        </footer>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarMenu = document.querySelector('.sidebar-menu');
            if (sidebarMenu) {
                const scrollPos = sessionStorage.getItem('sidebar-scroll');
                if (scrollPos !== null) {
                    sidebarMenu.scrollTop = parseInt(scrollPos, 10);
                }
                window.addEventListener('beforeunload', function() {
                    sessionStorage.setItem('sidebar-scroll', sidebarMenu.scrollTop);
                });
                sidebarMenu.addEventListener('scroll', function() {
                    sessionStorage.setItem('sidebar-scroll', sidebarMenu.scrollTop);
                });
            }
        });
    </script>
    <?php if (isset($_SESSION['swal_msg'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: '<?= $_SESSION['swal_type'] == "success" ? "Berhasil!" : "Perhatian!" ?>',
                text: '<?= addslashes($_SESSION['swal_msg']) ?>',
                icon: '<?= $_SESSION['swal_type'] ?>',
                confirmButtonColor: '#103F80'
            });
        });
    </script>
    <?php 
        unset($_SESSION['swal_msg']);
        unset($_SESSION['swal_type']);
    endif; 
    ?>
</body>
</html>
