import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

function clamp(v, lo, hi) {
  return Math.max(lo, Math.min(hi, v));
}

function lerp(a, b, t) {
  return a + (b - a) * t;
}

function initLandingEmblem() {
  const stageEl = document.getElementById('sibengkel-hero-3d');
  const canvas = document.getElementById('sibengkel-hero-canvas');
  if (!stageEl || !canvas) return;

  const modelUrl = stageEl.dataset.model || '/models/sibengkel.glb';

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({
      canvas,
      antialias: true,
      alpha: true,
      powerPreference: 'high-performance',
    });
  } catch {
    return;
  }

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.12;

  const scene = new THREE.Scene();
  const pmrem = new THREE.PMREMGenerator(renderer);
  scene.environment = pmrem.fromScene(new RoomEnvironment(), 0.04).texture;
  scene.environmentIntensity = 0.9;

  const camera = new THREE.PerspectiveCamera(34, 1, 0.1, 40);
  camera.position.set(0, 0.02, 4.0);

  const keyLight = new THREE.DirectionalLight(0xfff5ea, 2.2);
  keyLight.position.set(2.8, 4.5, 4.4);
  scene.add(keyLight);

  const fillLight = new THREE.DirectionalLight(0xd6d3cd, 0.75);
  fillLight.position.set(-3.8, -1.2, 2.2);
  scene.add(fillLight);

  const orangeRim = new THREE.SpotLight(0xff6b00, 14.0, 18, Math.PI / 3.0, 0.5, 1.1);
  orangeRim.position.set(-2.9, 2.2, -3.0);
  scene.add(orangeRim);

  const mat = new THREE.MeshStandardMaterial({
    color: 0xe6e6e8,
    metalness: 0.68,
    roughness: 0.24,
  });

  function applyTheme() {
    const isDark = document.documentElement.classList.contains('dark');
    if (isDark) {
      mat.color.setHex(0xe6e6e8);
      mat.metalness = 0.68;
      mat.roughness = 0.24;
      orangeRim.intensity = 14.0;
      scene.environmentIntensity = 0.92;
    } else {
      mat.color.setHex(0x1d1d1f);
      mat.metalness = 0.54;
      mat.roughness = 0.28;
      orangeRim.intensity = 14.0;
      scene.environmentIntensity = 0.72;
    }
    mat.needsUpdate = true;
  }
  applyTheme();

  new MutationObserver(applyTheme).observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class'],
  });

  const pivot = new THREE.Group();
  scene.add(pivot);

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let dragYaw = 0;
  let dragPitch = 0;
  let hoverX = 0;
  let hoverY = 0;
  let isDragging = false;
  let prevX = 0;
  let prevY = 0;

  stageEl.addEventListener('pointerdown', (e) => {
    isDragging = true;
    prevX = e.clientX;
    prevY = e.clientY;
    stageEl.setPointerCapture(e.pointerId);
  });

  stageEl.addEventListener('pointermove', (e) => {
    const rect = stageEl.getBoundingClientRect();
    if (rect.width > 0 && rect.height > 0) {
      hoverX = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
      hoverY = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
    }
    if (!isDragging) return;
    const dx = e.clientX - prevX;
    const dy = e.clientY - prevY;
    prevX = e.clientX;
    prevY = e.clientY;
    dragYaw += dx * 0.011;
    dragPitch = clamp(dragPitch + dy * 0.008, -0.58, 0.58);
  });

  const endDrag = () => {
    isDragging = false;
  };
  stageEl.addEventListener('pointerup', endDrag);
  stageEl.addEventListener('pointercancel', endDrag);
  stageEl.addEventListener('pointerleave', () => {
    hoverX = 0;
    hoverY = 0;
  });

  function resize() {
    const w = Math.max(1, stageEl.clientWidth);
    const h = Math.max(1, stageEl.clientHeight);
    renderer.setSize(w, h, false);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
  }
  resize();
  if ('ResizeObserver' in window) {
    new ResizeObserver(resize).observe(stageEl);
  }
  window.addEventListener('resize', resize, { passive: true });

  let curScrollYaw = 0;
  let curScrollPitch = 0;
  let curHoverX = 0;
  let curHoverY = 0;
  let elapsed = 0;
  let lastTime = performance.now();
  let rafId = 0;
  let loaded = false;

  const loader = new GLTFLoader();
  loader.load(
    modelUrl,
    (gltf) => {
      const model = gltf.scene;
      model.traverse((obj) => {
        if (obj.isMesh) {
          obj.material = mat;
        }
      });

      const upright = new THREE.Group();
      upright.rotation.x = Math.PI / 2;
      const box = new THREE.Box3().setFromObject(model);
      const center = box.getCenter(new THREE.Vector3());
      const size = box.getSize(new THREE.Vector3());
      const maxDim = Math.max(size.x, size.y, size.z) || 1;
      const normScale = 2.15 / maxDim;

      model.position.sub(center);
      upright.add(model);
      upright.scale.setScalar(normScale);
      pivot.add(upright);

      loaded = true;
      stageEl.classList.add('is-ready');
      resize();
    },
    undefined,
    () => {
      stageEl.classList.add('is-fallback');
    }
  );

  function frame(now) {
    rafId = requestAnimationFrame(frame);
    const dt = Math.min(0.05, Math.max(0.001, (now - lastTime) * 0.001));
    lastTime = now;

    const scrollRatio = clamp(window.scrollY / Math.max(1, window.innerHeight * 0.9), 0, 1);
    const targetScrollYaw = -0.25 + scrollRatio * 1.45;
    const targetScrollPitch = 0.06 - scrollRatio * 0.14;

    if (!isDragging) {
      dragYaw *= Math.exp(-1.5 * dt);
      dragPitch *= Math.exp(-1.6 * dt);
    }

    const alpha = reducedMotion ? 1 : 1 - Math.exp(-8.5 * dt);
    curScrollYaw = lerp(curScrollYaw, targetScrollYaw, alpha);
    curScrollPitch = lerp(curScrollPitch, targetScrollPitch, alpha);
    curHoverX = lerp(curHoverX, hoverX, alpha);
    curHoverY = lerp(curHoverY, hoverY, alpha);

    elapsed += dt;
    const idleFloat = reducedMotion ? 0 : Math.sin(elapsed * 1.1) * 0.02;
    const idleYaw = reducedMotion ? 0 : Math.sin(elapsed * 0.65) * 0.04;

    if (loaded) {
      pivot.rotation.y = curScrollYaw + dragYaw + curHoverX * 0.15 + idleYaw;
      pivot.rotation.x = curScrollPitch + dragPitch + curHoverY * 0.08;
      pivot.position.y = idleFloat;
      renderer.render(scene, camera);
    }
  }

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      cancelAnimationFrame(rafId);
      rafId = 0;
    } else if (!rafId) {
      lastTime = performance.now();
      rafId = requestAnimationFrame(frame);
    }
  });

  lastTime = performance.now();
  rafId = requestAnimationFrame(frame);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initLandingEmblem, { once: true });
} else {
  initLandingEmblem();
}
