<div class="navbar">
    <ul class="nav">
        <li class="nav-item">
            <a href="{{ route('products.show') }}" class="nav-link">Таблица</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('vinylmarkt-form') }}" class="nav-link">Vinylmarkt</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('get-available') }}" class="nav-link">Поиск доступных</a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link"></a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link"></a>
        </li>
    </ul>
</div>
<style>
    .navbar {
        position: fixed;
        width: 250px;
        height: 100%;
        border-right: 1px solid #000000;
    }

    .nav {
        padding: 10px 15px;
    }

    .nav-item {
        list-style-type: none;
    }

    .nav-link {
        display: block;
        color: #31344b;
        padding: 5px;
        text-decoration: none;
    }
</style>
