import './bootstrap';


const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.querySelector('.sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

if (sidebarToggle && sidebar && sidebarOverlay) {

    sidebarToggle.addEventListener('click', () => {

        sidebar.classList.toggle('show');

        sidebarOverlay.classList.toggle('d-none');

    });

    sidebarOverlay.addEventListener('click', () => {

        sidebar.classList.remove('show');

        sidebarOverlay.classList.add('d-none');

    });

}