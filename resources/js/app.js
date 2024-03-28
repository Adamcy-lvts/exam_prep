import './bootstrap';

import collapse from '@alpinejs/collapse'
import gsap from 'gsap';

Alpine.plugin(collapse)


// Heading Animation
const heading = document.querySelector('.gsap-heading');
gsap.from(heading, {
    y: -50,
    opacity: 0,
    duration: 1,
    ease: 'power3.out',
    delay: 0.5,
});

// Paragraph Animation
const paragraph = document.querySelector('.gsap-paragraph');
gsap.from(paragraph, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: 'power3.out',
    delay: 1,
});

// Button Animation
const buttons = document.querySelectorAll('.gsap-button');
buttons.forEach((button, index) => {
    gsap.fromTo(
        button,
        {
            y: 0, // Changed from 50 to 0
            opacity: 0,
        },
        {
            y: 50,
            opacity: 1,
            duration: 1,
            ease: 'power3.out',
            delay: 1.5 + (index * 0.2),
        }
    );
});