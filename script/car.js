import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { DRACOLoader } from 'three/addons/loaders/DRACOLoader.js';

const container = document.getElementById('car-container');
const scene = new THREE.Scene();

// 1. TOP VIEW CAMERA SETUP
const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.set(0, 50, 0); 
camera.lookAt(0, 0, 0);

const renderer = new THREE.WebGLRenderer({ 
    alpha: true, 
    antialias: true,
    powerPreference: "high-performance" 
});
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
container.appendChild(renderer.domElement);

// LIGHTING
scene.add(new THREE.AmbientLight(0xffffff, 3));
const light = new THREE.DirectionalLight(0xffffff, 3);
light.position.set(0, 20, 10);
scene.add(light);

// 2. SKID MARKS SETUP
const maxTrackPoints = 30; // Maikli lang para hindi makalat
const tracks = [];

// Gumamit ng gray material na mas visible
const trackMaterial = new THREE.MeshBasicMaterial({ 
    color: 0x808080, // Gray color
    transparent: true, 
    opacity: 0.4,
    side: THREE.DoubleSide,
    depthWrite: false // Para hindi mag-flicker sa ilalim ng car
});

function createTrackSegment() {
    // Mas malapad na segment para mas visible (0.8 width)
    const geometry = new THREE.PlaneGeometry(0.8, 0.3); 
    const mesh = new THREE.Mesh(geometry, trackMaterial.clone());
    mesh.rotation.x = -Math.PI / 2;
    return mesh;
}

// 3. LOADERS
const dracoLoader = new DRACOLoader();
dracoLoader.setDecoderPath('https://www.gstatic.com/draco/versioned/decoders/1.5.6/');
const loader = new GLTFLoader();
loader.setDRACOLoader(dracoLoader);

let car;
loader.load('./img/car.glb', (gltf) => {
    car = gltf.scene;
    const box = new THREE.Box3().setFromObject(car);
    const center = box.getCenter(new THREE.Vector3());
    car.position.sub(center); 
    car.scale.set(0.7, 0.7, 0.7);
    scene.add(car);
});

// 4. MOVEMENT VARIABLES
let mouse3D = new THREE.Vector3();
const speed = 0.05;
const rotationSpeed = 0.1;

window.addEventListener('mousemove', (e) => {
    const x = (e.clientX / window.innerWidth - 0.5) * 60;
    const z = (e.clientY / window.innerHeight - 0.5) * 35;
    mouse3D.set(x, 0, z);
});



function animate() {
    requestAnimationFrame(animate);

    if (car) {
        const direction = new THREE.Vector3().subVectors(mouse3D, car.position);
        const distance = direction.length();

        if (distance > 1.0) {
            direction.normalize();
            
            // Movement
            car.position.x += direction.x * speed;
            car.position.z += direction.z * speed;

            // Steering
            const targetRotation = Math.atan2(direction.x, direction.z);
            car.rotation.y = THREE.MathUtils.lerp(
                car.rotation.y, 
                targetAngleFix(car.rotation.y, targetRotation), 
                rotationSpeed
            );

            // 5. DRAW GRAY SKID MARKS
            // Naglalagay ng bakat habang naandar
            const track = createTrackSegment();
            // I-offset ng konti sa baba (y: -0.1) para hindi pumatong sa car mesh
            track.position.set(car.position.x, -0.1, car.position.z);
            track.rotation.z = car.rotation.y; 
            scene.add(track);
            tracks.push(track);
        }

        // 6. TRAIL MANAGEMENT (Short trail & Fading)
        if (tracks.length > maxTrackPoints) {
            const oldTrack = tracks.shift();
            scene.remove(oldTrack);
        }
        
        // Fading effect para sa dulo ng trail
        tracks.forEach((t, index) => {
            t.material.opacity = (index / tracks.length) * 0.4;
        });

        car.position.y = 0; 
    }

    renderer.render(scene, camera);
}

function targetAngleFix(current, target) {
    let diff = target - current;
    while (diff < -Math.PI) diff += Math.PI * 2;
    while (diff > Math.PI) diff -= Math.PI * 2;
    return current + diff;
}

window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});

animate();