import.meta.glob(["../images/**", "../fonts/**"]);

// Vendors
// import 'lax';
// Bootstrap 6: only the plugins used across the site (each module registers its data API).
// Catalog-only plugins (datepicker, chips, otp-input, strength, range, nav-overflow, toggler) are in pages/theme.js;
// import the others the same way where a page needs them, e.g. `import "bootstrap/js/dist/carousel.js";`
import "bootstrap/js/dist/alert.js";
import "bootstrap/js/dist/button.js";
import "bootstrap/js/dist/collapse.js";
import "bootstrap/js/dist/combobox.js";
import "bootstrap/js/dist/dialog.js";
import "bootstrap/js/dist/drawer.js";
import "bootstrap/js/dist/menu.js";
import "bootstrap/js/dist/popover.js";
import "bootstrap/js/dist/scrollspy.js";
import "bootstrap/js/dist/tab.js";
import "bootstrap/js/dist/toast.js";
import "bootstrap/js/dist/tooltip.js";

// PWA
import "/resources/js/pwa/pwa-manager.js";

// Components
// import '/resources/js/components/lax.js';
import "/resources/js/components/swal.js";
import "/resources/js/components/glightbox.js";
import "/resources/js/components/plyr.js";
import "/resources/js/components/combobox.js";

// Global usages
import "/resources/js/frontend.js";

// Pages
