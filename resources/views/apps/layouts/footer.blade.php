                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-fluid">
                        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                            @foreach(\App\Support\Footer::getFooterItems() as $footerItem)
                            <div>
                                © {{ date('Y') }}, Powered and designed by <a href="#" target="_blank" class="footer-link text-primary fw-medium">Ardia Nexus</a>
                            </div>
                            <div class="d-none d-lg-inline-block">
                                @foreach($footerItem['footer'] as $index => $footer)
                                <a href="{{ $footer['url'] }}" target="{{ $footer['target'] }}" class="footer-link {{ ($index === count($footerItem['footer']) - 1) ? 'd-none d-sm-inline-block' : 'me-4' }}">{{ $footer['text'] }}</a>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
