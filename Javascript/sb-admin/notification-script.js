trigger = function () {
    Slider.classList.toggle("slide-down");
    document.querySelector('.contents').style.pointerEvents = 'auto'; // Re-enable clicks when overlay is shown
};