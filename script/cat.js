import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { DRACOLoader } from 'three/addons/loaders/DRACOLoader.js';

const container = document.getElementById('car-container');
const scene = new THREE.Scene();

// 1. TOP VIEW CAMERA
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

// 2. CAT TRAIL SETUP (Ghost/Aura effect instead of skid marks)
const maxTrackPoints = 40; 
const tracks = [];
const trackMaterial = new THREE.MeshBasicMaterial({ 
    color: 0x60A5FA, // Light blue aura (baguhin mo kung gusto mo ng ibang kulay)
    transparent: true, 
    opacity: 0.3,
    side: THREE.DoubleSide,
    depthWrite: false 
});

function createTrackSegment() {
    // Mas maliit na segment dahil pusa ito, hindi kotse
    const geometry = new THREE.PlaneGeometry(0.5, 0.2); 
    const mesh = new THREE.Mesh(geometry, trackMaterial.clone());
    mesh.rotation.x = -Math.PI / 2;
    return mesh;
}

// 3. LOADERS
const dracoLoader = new DRACOLoader();
dracoLoader.setDecoderPath('https://www.gstatic.com/draco/versioned/decoders/1.5.6/');
const loader = new GLTFLoader();
loader.setDRACOLoader(dracoLoader);

let cat; // Rename variable to cat
let mixer; // Para sa animation ng pusa
const clock = new THREE.Clock();

loader.load('./img/cat.glb', (gltf) => {
    cat = gltf.scene;
    
    // Auto-scale logic para hindi siya maging higante
    const box = new THREE.Box3().setFromObject(cat);
    const size = new THREE.Vector3();
    box.getSize(size);
    const targetSize = 2.5; 
    const scale = targetSize / Math.max(size.x, size.y, size.z);
    cat.scale.set(scale, scale, scale);

    const center = box.getCenter(new THREE.Vector3());
    cat.position.sub(center.multiplyScalar(scale)); 
    
    scene.add(cat);

    // 4. ANIMATION SETUP (Kung may "walk" animation ang glb mo)
    if (gltf.animations.length > 0) {
        mixer = new THREE.AnimationMixer(cat);
        // Karaniwan "Walk" o "Run" ang pangalan, or index 0
        const action = mixer.clipAction(gltf.animations[0]); 
        action.play();
    }
});

// 5. MOVEMENT VARIABLES
let mouse3D = new THREE.Vector3();
const speed = 0.08; // Mas mabilis ng konti sa kotse para "agile"
const rotationSpeed = 0.15;

window.addEventListener('mousemove', (e) => {
    const x = (e.clientX / window.innerWidth - 0.5) * 60;
    const z = (e.clientY / window.innerHeight - 0.5) * 35;
    mouse3D.set(x, 0, z);
});

function animate() {
    requestAnimationFrame(animate);
    const delta = clock.getDelta();

    if (mixer) mixer.update(delta);

    if (cat) {
        const direction = new THREE.Vector3().subVectors(mouse3D, cat.position);
        const distance = direction.length();

        if (distance > 0.8) { // Mas dikit na threshold
            direction.normalize();
            
            cat.position.x += direction.x * speed;
            cat.position.z += direction.z * speed;

            const targetRotation = Math.atan2(direction.x, direction.z);
            cat.rotation.y = THREE.MathUtils.lerp(
                cat.rotation.y, 
                targetAngleFix(cat.rotation.y, targetRotation), 
                rotationSpeed
            );

            // 6. DRAW CAT TRAIL
            const track = createTrackSegment();
            track.position.set(cat.position.x, -0.05, cat.position.z);
            track.rotation.z = cat.rotation.y; 
            scene.add(track);
            tracks.push(track);
        }

        // TRAIL MANAGEMENT
        if (tracks.length > maxTrackPoints) {
            const oldTrack = tracks.shift();
            scene.remove(oldTrack);
        }
        
        tracks.forEach((t, index) => {
            t.material.opacity = (index / tracks.length) * 0.3;
        });

        cat.position.y = 0; 
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