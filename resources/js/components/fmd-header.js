// Hide Header on scroll down
export function setupFmdHeader() {
    // Return element's offset top
    function getOffsetTop(selector) {
        return (
            document.getElementsByClassName(selector)[0].getBoundingClientRect()
                .top + window.scrollY
        );
    }

    // Return if selector was found
    function isElementSet(selector) {
        return !!document.getElementsByClassName(selector).length;
    }

    function showHeader() {
        header.classList.remove(hideClass);
        // header.style.transform = 'none';
    }

    function hideHeader() {
        header.classList.add(hideClass);
        // header.style.transform = 'translateY(-100%)';
    }

    function setStickyHeader() {
        header.classList.add(fixedClass);
        header.style.position = "fixed";
    }

    function unsetStickyHeader() {
        header.classList.remove(fixedClass);
        header.style.position = "absolute";
    }

    function setHeaderTransition(newTransition) {
        header.style.transitionDuration = `${newTransition}ms`;
    }

    function setHeaderHeight(headerHeight) {
        document.documentElement.style.setProperty(
            "--header-height",
            headerHeight + "px",
        );
    }

    function setupResizeScreenHeader() {
        const initialDimensions = {
            width: window.innerWidth,
            height: window.innerHeight,
        };

        function handleResize() {
            const currentDimensions = {
                width: window.innerWidth,
                height: window.innerHeight,
            };
            const hasHeaderFixed = header.classList.contains(fixedClass);

            // check the width and height of the screen to prevent when the browser
            // bar hides or when rotating the mobile screen in the landscape model
            // to not perform the resize
            if (
                (currentDimensions.width === initialDimensions.width &&
                    currentDimensions.height >= initialDimensions.height) ||
                hasHeaderFixed
            ) {
                return;
            }

            setTimeout(() => {
                setHeaderHeight(header.offsetHeight);
            }, headerTransition);
        }

        window.addEventListener("resize", handleResize);
    }

    // Initialize variables
    let isFrameScheduled = false;
    let lastScrollTop = 0;
    let fixedTimer;
    const delta = 5; // Minimum scroll value

    // Set classes
    const headerClass = "fmd-header";
    const startTargetClass = "fmd-header-start-target";
    const endTargetClass = "fmd-header-end-target";
    const hideClass = "fmd-header-is-hidden";
    const fixedClass = "fmd-header-is-fixed";

    // If fixed header class wasn't found
    if (!isElementSet(headerClass)) {
        console.error(
            `Use a classe "${headerClass}" no <header> para ativar o fixed header`,
        );
        return;
    }

    // Select fixed header
    const header = document.querySelector(`.${headerClass}`);
    const headerTransition =
        Number(
            getComputedStyle(header)["transition-duration"].replace("s", ""),
        ) * 1000;

    // Read on each scroll, not once on load: the page grows later (lazy images, infinite scroll, Livewire)
    // Start target where header will be fixed | Default: Window Height (100vh)
    function getStartTarget() {
        return isElementSet(startTargetClass)
            ? getOffsetTop(startTargetClass)
            : window.outerHeight;
    }

    // End target where header will be shown | Default: The page bottom
    function getEndTarget() {
        return isElementSet(endTargetClass)
            ? getOffsetTop(endTargetClass)
            : document.body.scrollHeight;
    }

    // Set variable that is used to apply padding-top to the body
    header.style.position = "absolute";

    setHeaderHeight(header.offsetHeight);

    setupResizeScreenHeader();

    // Handles the scroll at most once per frame, and only while the page scrolls
    window.addEventListener(
        "scroll",
        () => {
            if (isFrameScheduled) {
                return;
            }

            isFrameScheduled = true;

            requestAnimationFrame(() => {
                isFrameScheduled = false;
                hasScrolled();
            });
        },
        { passive: true },
    );

    // When window gets scrolled
    function hasScrolled() {
        const st = window.scrollY;

        // Update last scroll top
        function updateLastScroll() {
            lastScrollTop = st;
        }

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta) {
            return;
        }

        setHeaderTransition(headerTransition);

        // If the window bottom reaches end target
        if (st + window.outerHeight >= getEndTarget()) {
            // A fast scroll reaches the end before the fixed timer: fixes the header while it is hidden
            // (the logo shrinks out of sight), then slides it in, instead of popping it in with the large logo
            if (
                !header.classList.contains(fixedClass) &&
                st > getStartTarget()
            ) {
                window.clearTimeout(fixedTimer);
                setHeaderTransition(0);
                hideHeader();
                setStickyHeader();

                fixedTimer = window.setTimeout(function () {
                    setHeaderTransition(headerTransition);
                    showHeader();
                }, headerTransition);

                updateLastScroll();
                return;
            }

            showHeader();
            updateLastScroll();
            return;
        }

        // If scroll down and passes start target
        if (st > lastScrollTop && st > getStartTarget()) {
            window.clearTimeout(fixedTimer);

            fixedTimer = window.setTimeout(function () {
                setStickyHeader();
            }, headerTransition);
        }

        // If scroll down and passes header height
        if (st > lastScrollTop && st > header.offsetHeight) {
            hideHeader();
            updateLastScroll();
            return;
        }

        // If scroll up
        showHeader();

        if (st < header.offsetHeight) {
            setHeaderTransition(0);
        }

        if (st === 0) {
            unsetStickyHeader();
        }

        updateLastScroll();
    }
}
