export function getThemeVariables() {
    const root = getComputedStyle(document.documentElement);

    // Read 'from --bs-breakpoint-??' (min-width)
    const breakpoints = {
        xs: Number(
            root.getPropertyValue("--bs-breakpoint-xs").replace("px", ""),
        ),
        sm: Number(
            root.getPropertyValue("--bs-breakpoint-sm").replace("px", ""),
        ),
        md: Number(
            root.getPropertyValue("--bs-breakpoint-md").replace("px", ""),
        ),
        lg: Number(
            root.getPropertyValue("--bs-breakpoint-lg").replace("px", ""),
        ),
        xl: Number(
            root.getPropertyValue("--bs-breakpoint-xl").replace("px", ""),
        ),
        xxl: Number(
            root.getPropertyValue("--bs-breakpoint-xxl").replace("px", ""),
        ),
    };

    function isWindowWidthUp(breakpoint) {
        return window.innerWidth >= breakpoints[breakpoint];
    }

    function isWindowWidthDown(breakpoint) {
        return window.innerWidth < breakpoints[breakpoint];
    }

    return {
        breakpoints,
        collapseTransitionTime: 350, // In milliseconds
        colors: {
            primary: root.getPropertyValue("--bs-primary"),
            secondary: root.getPropertyValue("--bs-secondary"),
            success: root.getPropertyValue("--bs-success"),
            info: root.getPropertyValue("--bs-info"),
            warning: root.getPropertyValue("--bs-warning"),
            danger: root.getPropertyValue("--bs-danger"),
            light: root.getPropertyValue("--bs-light"),
            dark: root.getPropertyValue("--bs-dark"),
        },
        isWindowWidthUp,
        isWindowWidthDown,
    };
}
