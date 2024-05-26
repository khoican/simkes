<menu class="container-fluid">
    <div class="d-flex justify-content-between">
        <div class="d-flex gap-5 align-items-center fs-5">
            <a href="/" class="nav-link fw-medium text-secondary"><i class="bi bi-house-door-fill"></i>
                Dashboard</a>
            <a href="/pendaftaran" class="nav-link fw-medium text-secondary"><i class="bi bi-file-text-fill"></i>
                Pendaftaran</a>
            <a href="/pemeriksaan" class="nav-link fw-medium text-secondary"><i class="bi bi-heart-pulse-fill"></i>
                Pemeriksaan</a>
            <a href="/apotek" class="nav-link fw-medium text-secondary"><i class="bi bi-capsule"></i> Apotek</a>
        </div>

        <div class="d-flex align-items-center fw-medium gap-3 fs-6" style="width: 30%;">
            <p class="mb-0 text-end" style="width: 70%;"><i class="bi bi-calendar-week-fill"></i> <span
                    id="date"></span></p>
            <p class="mb-0" style="width: 30%;"><i class="bi bi-clock-fill"></i> <span id="time"></span></p>
        </div>
    </div>
</menu>

<script>
$(document).ready(function() {
    let path = window.location.pathname.split('/');

    $('.nav-link').each(function() {
        if ($(this).attr('href').replace('/', '') == path[1]) {
            $(this).addClass('text-primary');
            $(this).removeClass('text-secondary');
        }
    })

    setInterval(() => {
        $('document').ready(function() {
            $('#date').text(moment().format('DD MMMM YYYY'));
            $('#time').text(moment().format('HH:mm:ss'));
        })
    }, 1000);
})
</script>