export async function setupInfiniteScroll() {
    const scrollContainerElement = document.querySelector(".infinite-scroll");
    const nextElementSelector = 'a[rel~="next"]';
    const nextPageElement = document.querySelector(nextElementSelector);

    if (!scrollContainerElement || !nextPageElement) {
        return;
    }

    const { default: InfiniteScroll } = await import("infinite-scroll");

    new InfiniteScroll(scrollContainerElement, {
        path: nextElementSelector,
        append: ".infinite-scroll-content",
        scrollThreshold: 100,
        status: ".page-load-status",
        history: "push",
    });
}
