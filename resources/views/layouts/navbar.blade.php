<div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">123 Street, New York</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="index.html" class="navbar-brand"><h1 class="text-primary display-6">Fruitables</h1></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                          {{-- <a href="{{ route('home') }}" 
                            class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            Home
                            </a> --}}

                            <a href="{{ route('shop') }}" 
                            class="nav-item nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">
                            Shop
                            </a>

                             <a href="{{route('cart')}}" 
                            class="nav-item nav-link {{ request()->routeIs('cart') ? 'active' : '' }}">
                            cart
                            </a>
                                    {{-- <a href="shop-detail.html" class="nav-item nav-link">Shop Detail</a> --}}
                            {{-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="{{route('cart')}}" class="dropdown-item">Cart</a>
                                    <a href="{{route('checkout')}}" class="dropdown-item">Chackout</a>
                                    <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                    <a href="404.html" class="dropdown-item">404 Page</a>
                                </div> --}}
                            </div>
                            <a href="contact.html" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="d-flex m-3 me-0">
                            <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                            <a href="#" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                            </a>
                            <a href="#" class="my-auto">
                                <i class="fas fa-user fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>


 <script>
document.addEventListener('DOMContentLoaded', () => {
    const searchModal = document.getElementById('searchModal');


    searchModal?.addEventListener('shown.bs.modal', () => {
        const input = searchModal.querySelector('input[type="search"]');
        if (!input) return;

    
        const parent = input.parentElement;
        parent.style.position = 'relative';

        // إنشاء قائمة النتائج
        let resultsBox = document.createElement('ul');
        resultsBox.id = 'searchResults';
        resultsBox.className = 'list-group position-absolute bg-white shadow border rounded w-100 mt-1';
        resultsBox.style.top = '100%';
        resultsBox.style.left = '0';
        resultsBox.style.zIndex = '1056';
        resultsBox.style.display = 'none';
        resultsBox.style.maxHeight = '250px';
        resultsBox.style.overflowY = 'auto';
        parent.appendChild(resultsBox);

      
        input.addEventListener('keyup', async () => {
            const query = input.value.trim();
            if (query.length < 2) {
                resultsBox.style.display = 'none';
                resultsBox.innerHTML = '';
                return;
            }

            try {
                const response = await axios.get(`/api/search`, {
                    params: { query }
                });
                const products = response.data;

               
                if (products.length > 0) {
                    resultsBox.innerHTML = products.map(p => `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${p.name}</strong><br>
                                <small class="text-muted">$${p.price}</small>
                            </div>
                            <a href="/product" class="btn btn-sm btn-outline-primary">View</a>
                        </li>
                    `).join('');
                    resultsBox.style.display = 'block';
                } else {
                    resultsBox.innerHTML = `<li class="list-group-item text-muted">No results found</li>`;
                    resultsBox.style.display = 'block';
                }

            } catch (err) {
                console.error(err);
                resultsBox.innerHTML = `<li class="list-group-item text-danger">Error fetching results</li>`;
                resultsBox.style.display = 'block';
            }
        });

        
        document.addEventListener('click', e => {
            if (!parent.contains(e.target)) {
                resultsBox.style.display = 'none';
            }
        });
    });
});
</script>