
document.addEventListener("DOMContentLoaded", function () {
    bindActionButtons();
});

function bindActionButtons() {
    const actionBtns = document.querySelectorAll('.btn-view, .btn-edit, .btn-trash');

    actionBtns.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const link = this.getAttribute('data-link');
            if (!link) {
                console.error("No data-link found!");
                return;
            }

            const overlay = document.getElementById('overlayBlur');
            const loaderBar = document.getElementById('topLoaderBar');

            if (overlay) {
                overlay.classList.add('active');
                overlay.style.display = 'block';
            }

            if (loaderBar) {
                loaderBar.style.display = 'block';
                loaderBar.style.width = '0%';
                setTimeout(() => {
                    loaderBar.style.transition = 'width 1.5s ease-in-out';
                    loaderBar.style.width = '100%';
                }, 50);
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });

            setTimeout(() => {
                window.location.href = link;
            }, 2000);
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    //Add New Card Click Handler (Loader + Redirect)
    const addNewCard = document.getElementById('addNewCard');
    if (addNewCard) {
        addNewCard.addEventListener('click', function () {
            const overlay = document.getElementById('overlayBlur');
            const loaderBar = document.getElementById('topLoaderBar');
            const link = this.getAttribute('data-link');

            if (overlay) overlay.classList.add('active');
            if (loaderBar) {
                loaderBar.style.display = "block";
                loaderBar.style.width = "0%";
                setTimeout(() => {
                    loaderBar.style.width = "100%";
                }, 50);
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });

            setTimeout(() => {
                window.location.href = link;
            }, 2000);
        });
    }

    //Format Mobile Number
    const mobileInput = document.getElementById('mobile_no');
    if (mobileInput) {
        mobileInput.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.slice(0, 5) + "-" + value.slice(5, 10);
            }
            this.value = value.slice(0, 11);
        });
    }

    //Format Monthly Salary
    const salaryInput = document.getElementById('monthly_salary');
    if (salaryInput) {
        salaryInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
        });
    }

    //Form Submit Blur + Delay + Loader Animation
    const customerForm = document.getElementById('customerForm');
    if (customerForm) {
        customerForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const overlay = document.getElementById('overlayBlur');
            const loaderBar = document.getElementById('topLoaderBar');

            if (overlay) overlay.classList.add('active');

            if (loaderBar) {
                loaderBar.style.display = "block";
                loaderBar.style.width = "0%";
                setTimeout(() => {
                    loaderBar.style.width = "100%";
                }, 50);
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });

            setTimeout(() => {
                customerForm.submit();
            }, 2000);
        });
    }

    //BACK button blur effect
    window.addEventListener('pageshow', function (event) {
        const overlay = document.getElementById('overlayBlur');
        const loaderBar = document.getElementById('topLoaderBar');

        if (event.persisted || (performance.navigation && performance.navigation.type === 2)) {
            if (overlay) overlay.classList.add('active');
            if (loaderBar) {
                loaderBar.style.display = "block";
                loaderBar.style.width = "0%";
                setTimeout(() => {
                    loaderBar.style.width = "100%";
                }, 50);

                setTimeout(() => {
                    loaderBar.style.display = "none";
                    overlay.classList.remove('active');
                }, 2000);
            }
        }
    });

    //View Button (Loader + Blur + Scroll)
    const viewBtns = document.querySelectorAll('.btn-view');
    viewBtns.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const overlay = document.getElementById('overlayBlur');
            const loaderBar = document.getElementById('topLoaderBar');
            const link = this.getAttribute('data-link');

            if (overlay) overlay.classList.add('active');

            if (loaderBar) {
                loaderBar.style.display = "block";
                loaderBar.style.width = "0%";
                setTimeout(() => {
                    loaderBar.style.width = "100%";
                }, 50);
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });

            setTimeout(() => {
                window.location.href = link;
            }, 2000);
        });
    });

    //Edit Button (Loader + Blur + Scroll)
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const overlay = document.getElementById('overlayBlur');
            const loaderBar = document.getElementById('topLoaderBar');
            const link = this.getAttribute('data-link');

            if (overlay) overlay.classList.add('active');

            if (loaderBar) {
                loaderBar.style.display = "block";
                loaderBar.style.width = "0%";
                setTimeout(() => {
                    loaderBar.style.width = "100%";
                }, 50);
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });

            setTimeout(() => {
                window.location.href = link;
            }, 2000);
        });
    });

    //Reload Page with Loader and Blur on "All" Button
    const reloadPageBtn = document.getElementById('reloadPageBtn');
    if (reloadPageBtn) {
        reloadPageBtn.addEventListener('click', function () {
            const overlay = document.getElementById('overlayBlur');
            const loaderBar = document.getElementById('topLoaderBar');

            if (overlay) overlay.classList.add('active');

            if (loaderBar) {
                loaderBar.style.display = "block";
                loaderBar.style.width = "0%";
                loaderBar.style.transition = "width 1s ease-in-out";

                setTimeout(() => {
                    loaderBar.style.width = "100%";
                }, 50);
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });

            setTimeout(() => {
                window.location.href = window.location.href;
            }, 1400);
        });
    }
});
