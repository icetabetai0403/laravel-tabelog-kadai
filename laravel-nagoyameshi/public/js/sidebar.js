function adjustSidebar() {
    const sidebar = document.querySelector(".sidebar-wrapper");
    const mainContent = document.getElementById("main-content");
    const headerHeight = parseInt(
        getComputedStyle(document.documentElement).getPropertyValue(
            "--header-height"
        )
    );

    function update() {
        const windowHeight = window.innerHeight;
        const mainContentHeight = mainContent.offsetHeight;

        if (window.innerWidth >= 768) {
            // デスクトップビュー
            sidebar.style.height = `${Math.max(
                windowHeight - headerHeight,
                mainContentHeight
            )}px`;
            sidebar.style.position = "sticky";
        } else {
            // モバイルビュー
            sidebar.style.height = "auto";
            sidebar.style.position = "static";
        }
    }

    window.addEventListener("scroll", update);
    window.addEventListener("resize", update);
    update(); // 初期化時に一度実行
}

window.addEventListener("load", adjustSidebar);
