import './bootstrap';
// import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import { gsap } from 'gsap';


// Set initial state for all text sections to invisible
gsap.set('.gsap-text', { autoAlpha: 0 });

// Function to animate the entrance and exit for each text element
function animateTextElements(textContainer) {
    // Define selectors for the child elements
    const heading = textContainer.querySelector('.gsap-heading');
    const paragraph = textContainer.querySelector('.gsap-paragraph');

    // Create a timeline for this container
    const tl = gsap.timeline({
        onStart: () => gsap.set(textContainer, { autoAlpha: 1 }),
        onComplete: () => gsap.set(textContainer, { autoAlpha: 0 })
    });

    // Animate the heading and paragraph entering
    tl.fromTo(heading, { x: -400, autoAlpha: 0 }, { x: 0, autoAlpha: 1, duration: 2, ease: 'power3.out' })
        .fromTo(paragraph, { x: 400, autoAlpha: 0 }, { x: 0, autoAlpha: 1, duration: 2, ease: 'power3.out' }, "<")
        // Add a slight delay before exiting
        .to({}, { duration: 4 }) // Time visible on screen before starting to exit
        // Animate the heading and paragraph exiting in opposite directions
        .to(heading, { x: 400, autoAlpha: 0, duration: 1, ease: 'power3.in' })
        .to(paragraph, { x: -400, autoAlpha: 0, duration: 1, ease: 'power3.in' }, "<");

    return tl;
}

// Calculate total animation time per text container
const enterDuration = 2; // Time for text to slide in
const visibleDuration = 4; // Time text remains visible
const exitDuration = 1; // Time for text to slide out
const totalDurationPerText = enterDuration + visibleDuration + exitDuration; // Total time each text is animated

// Create a master timeline that will control when each text container's animations play
const masterTl = gsap.timeline({ repeat: -1 });

// Add each text container's animations to the master timeline
document.querySelectorAll('.gsap-text').forEach((text, index) => {
    masterTl.add(animateTextElements(text), index * totalDurationPerText);
});

// Calculate repeat delay to eliminate gap at the end before restarting
masterTl.repeatDelay(0);


// Start the master timeline
masterTl.play();



