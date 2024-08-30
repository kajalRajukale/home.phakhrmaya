document.addEventListener('DOMContentLoaded', () => {
    const slideshows = document.querySelectorAll('.slideshow');
    
    slideshows.forEach(slideshow => {
        const images = slideshow.querySelectorAll('img');
        let currentIndex = 0;
        
        function showNextImage() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }
        
        setInterval(showNextImage, 3000); // Change slide every 3 seconds
    });
});

// Example of adding dynamic behavior, like a console log when a nav item is clicked
document.querySelectorAll('.navbar ul li a').forEach(link => {
    link.addEventListener('click', () => {
        console.log(link.textContent + ' clicked');
    });
});
