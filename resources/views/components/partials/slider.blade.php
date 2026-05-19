<div class="relative max-w-4xl mx-auto h-87.5 overflow-hidden rounded-2xl mb-10">

    <!-- Slides -->
    <div id="slider" class="flex h-full transition-transform duration-700 ease-in-out">
        <img src="https://picsum.photos/id/1018/1200/400" class="w-full h-full object-cover shrink-0">
        <img src="https://picsum.photos/id/1015/1200/400" class="w-full h-full object-cover shrink-0">
        <img src="https://picsum.photos/id/1016/1200/400" class="w-full h-full object-cover shrink-0">
        <img src="https://picsum.photos/id/1018/1200/400" class="w-full h-full object-cover shrink-0">
    </div>

    <!-- Dots -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-3 z-10">
        <button class="dot w-3 h-3 rounded-full bg-white/40 transition-all duration-300"></button>
        <button class="dot w-3 h-3 rounded-full bg-white/40 transition-all duration-300"></button>
        <button class="dot w-3 h-3 rounded-full bg-white/40 transition-all duration-300"></button>
    </div>
</div>

<script>
    const slider = document.getElementById("slider");
    const dots = document.querySelectorAll(".dot");

    const totalSlides = 3;
    let index = 1;
    let isTransitioning = false;

    slider.style.transform = `translateX(-100%)`;

    function updateDots() {
        dots.forEach(dot => dot.classList.remove("bg-white", "scale-125"));
        dots[(index - 1 + totalSlides) % totalSlides]
            .classList.add("bg-white", "scale-125");
    }

    function nextSlide() {
        if (isTransitioning) return;
        isTransitioning = true;
        index++;
        slider.style.transition = "transform 0.7s ease-in-out";
        slider.style.transform = `translateX(-${index * 100}%)`;
    }

    slider.addEventListener("transitionend", () => {
        isTransitioning = false;

        if (index === totalSlides + 1) {
            slider.style.transition = "none";
            index = 1;
            slider.style.transform = `translateX(-100%)`;
        }

        updateDots();
    });

    dots.forEach((dot, i) => {
        dot.addEventListener("click", () => {
            index = i + 1;
            slider.style.transition = "transform 0.7s ease-in-out";
            slider.style.transform = `translateX(-${index * 100}%)`;
            updateDots();
        });
    });

    setInterval(nextSlide, 4000);

    updateDots();
</script>
