import './bootstrap';
// import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import { gsap } from 'gsap';

// Alpine.plugin(collapse)

// Heading and Paragraph Animation
// gsap.from('.gsap-heading', {
//     x: -100,
//     opacity: 0,
//     duration: 1,
//     ease: 'power3.out',
//     delay: 0.5,
// });

// gsap.from('.gsap-paragraph', {
//     x: 100,
//     opacity: 0,
//     duration: 1,
//     ease: 'power3.out',
//     delay: 1,
// });

// Button Animation
// const buttons = document.querySelectorAll('.gsap-button');
// buttons.forEach((button, index) => {
//     gsap.from(button, {
//         y: 20,
//         opacity: 0,
//         duration: 1,
//         ease: 'power3.out',
//         delay: 1.5 + (index * 0.2),
//     });
// });

//Set the initial state for the rotating texts
// gsap.set('.gsap-text', { x: -200, autoAlpha: 0 });

// // Function to create the timeline for each text set with alternating slide directions
// function createTimeline(textElement, index) {
//     const direction = index % 2 === 0 ? 200 : -200; // Alternate the direction
//     const tl = gsap.timeline();
//     tl.to(textElement, { duration: 1, x: 0, autoAlpha: 1, ease: 'power3.out' })
//         .to(textElement, { duration: 1, x: direction, autoAlpha: 0, ease: 'power3.in' }, '+=4');
//     return tl;
// }

// // Master timeline that controls the sequence of each text set
// const masterTl = gsap.timeline({ repeat: -1, repeatDelay: 1 });
// const texts = document.querySelectorAll('.gsap-text');

// // Add each text set's timeline to the master timeline
// texts.forEach((text, index) => {
//     masterTl.add(createTimeline(text, index));
// });

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



