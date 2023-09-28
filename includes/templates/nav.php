<div class="col-12 px-0 bg-gray">
    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'entradas.php') ? 'active' : ''; ?> fw-bold" href="entradas.php">Entradas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'salidas.php') ? 'active' : ''; ?> fw-bold" href="salidas.php">Salidas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'transacciones.php') ? 'active' : ''; ?> fw-bold" href="transacciones.php">Transacciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'balance_general.php') ? 'active' : ''; ?> fw-bold" href="balance_general.php">Balance General</a>
        </li>
    </ul>
</div>
