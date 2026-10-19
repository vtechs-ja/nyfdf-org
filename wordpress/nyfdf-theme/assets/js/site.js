(function () {
	// Years of service
	var yearsEl = document.getElementById('stat-years');
	if (yearsEl) {
		yearsEl.textContent = (new Date().getFullYear() - 2008) + '+';
	}

	// Mobile nav toggle
	var toggle = document.querySelector('.nav-toggle');
	if (toggle) {
		toggle.addEventListener('click', function () {
			document.body.classList.toggle('nav-open');
			var expanded = document.body.classList.contains('nav-open');
			toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		});

		// Close nav when a link is clicked
		document.querySelectorAll('.nav-links a').forEach(function (link) {
			link.addEventListener('click', function () {
				document.body.classList.remove('nav-open');
				toggle.setAttribute('aria-expanded', 'false');
			});
		});

		// Close nav on ESC
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && document.body.classList.contains('nav-open')) {
				document.body.classList.remove('nav-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.focus();
			}
		});
	}
})();
