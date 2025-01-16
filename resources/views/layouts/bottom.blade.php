<div class="appBottomMenu">
    <a href="/dashboard" class="item {{ request()->is('dashboard') ? 'active' : ''}}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="/attandance/histori" class="item {{ request()->is('attandance/histori') ? 'active' : ''}}">
        <div class="col">
                <ion-icon name="folder-open-outline" role="img" class="md hydrated"></ion-icon>
            <strong>History</strong>
        </div>
    </a>
    <a href="/attandance/create" class="item">
        <div class="col">
            <div class="action-button large" style="background-color: #445a79">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="/attandance/izin" class="item {{ request()->is('attandance/izin') ? 'active' : ''}}">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated"
                aria-label="calendar-outline"></ion-icon>
            <strong>Cuti</strong>
        </div>
    </a>
    <a href="/editprofil"  class="item {{ request()->is('editprofil') ? 'active' : ''}}">
        <div class="col">
            <ion-icon name="people-circle-outline" role="img" class="md hydrated" aria-label="people-circle-outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
