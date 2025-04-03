<div x-data="colorPicker('#ffffff'), isHexDragging = false, isHueDragging = false"
     :class="showPicker ? 'opacity-100 scale-100 pointer-events-auto' : 'opacity-0 scale-90 pointer-events-none'"
     x-cloak
     @mousedown.away="showPicker = false"
     x-on:show-color-picker.window="showColorPicker($event)"
     :style="{ top: inputPosition.y + 'px', left: inputPosition.x + 'px' }"
     class="absolute w-52 translate-y-2 bg-primary-100 shadow-lg rounded-lg z-50 transition-[scale, opacity] duration-300"
     x-init="if(showPicker) updateFromHex()">
    <div class="relative z-10 h-32 cursor-pointer select-none"
         id="color-picker-hex"
         :style="{ background: 'hsl(' + hue + ', 100%, 50%)'}"
         @mousedown="isHexDragging = true; pickColor($event); $event.preventDefault()"
         @mouseup.window="if(isHexDragging) updateColor(); if(isHexDragging) $dispatch('color-picked', { hex: selectedHex, cindex: cindex }); isHexDragging = false"
         @mousemove.window="if(isHexDragging) pickColor($event)">
        <div class="absolute pointer-events-none inset-0 bg-gradient-to-r from-white to-transparent"></div>
        <div class="absolute pointer-events-none inset-0 bg-gradient-to-t from-black to-transparent"></div>

        <div class="absolute pointer-events-none w-4 h-4 border-2 border-white rounded-full transform -translate-x-2 -translate-y-2"
             :style="{ top: selectedPos.y + '%', left: selectedPos.x + '%', background: hsvToHex(hue, selectedPos.x, 100-selectedPos.y)}"></div>
    </div>


    <!-- Barre de teinte -->
    <div class="h-4 relative select-none"
         id="color-picker-hue"
         @mousedown="isHueDragging = true, pickHue($event); $event.preventDefault()"
         @mouseup.window="if(isHueDragging) updateColor(); if(isHueDragging) $dispatch('color-picked', { hex: selectedHex, cindex: cindex }); isHueDragging = false"
         @mousemove.window="if(isHueDragging) pickHue($event)">
        <svg width="208" height="24" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="Gradient1">
                    <stop offset="0%" stop-color="hsl(0, 100%, 50%)"/>
                    <stop offset="1%" stop-color="hsl(3, 100%, 50%)"/>
                    <stop offset="2%" stop-color="hsl(7, 100%, 50%)"/>
                    <stop offset="3%" stop-color="hsl(10, 100%, 50%)"/>
                    <stop offset="4%" stop-color="hsl(14, 100%, 50%)"/>
                    <stop offset="5%" stop-color="hsl(18, 100%, 50%)"/>
                    <stop offset="6%" stop-color="hsl(21, 100%, 50%)"/>
                    <stop offset="7%" stop-color="hsl(25, 100%, 50%)"/>
                    <stop offset="8%" stop-color="hsl(28, 100%, 50%)"/>
                    <stop offset="9%" stop-color="hsl(32, 100%, 50%)"/>
                    <stop offset="10%" stop-color="hsl(36, 100%, 50%)"/>
                    <stop offset="11%" stop-color="hsl(39, 100%, 50%)"/>
                    <stop offset="12%" stop-color="hsl(43, 100%, 50%)"/>
                    <stop offset="13%" stop-color="hsl(46, 100%, 50%)"/>
                    <stop offset="14%" stop-color="hsl(50, 100%, 50%)"/>
                    <stop offset="15%" stop-color="hsl(54, 100%, 50%)"/>
                    <stop offset="16%" stop-color="hsl(57, 100%, 50%)"/>
                    <stop offset="17%" stop-color="hsl(61, 100%, 50%)"/>
                    <stop offset="18%" stop-color="hsl(64, 100%, 50%)"/>
                    <stop offset="19%" stop-color="hsl(68, 100%, 50%)"/>
                    <stop offset="20%" stop-color="hsl(72, 100%, 50%)"/>
                    <stop offset="21%" stop-color="hsl(75, 100%, 50%)"/>
                    <stop offset="22%" stop-color="hsl(79, 100%, 50%)"/>
                    <stop offset="23%" stop-color="hsl(82, 100%, 50%)"/>
                    <stop offset="24%" stop-color="hsl(86, 100%, 50%)"/>
                    <stop offset="25%" stop-color="hsl(90, 100%, 50%)"/>
                    <stop offset="26%" stop-color="hsl(93, 100%, 50%)"/>
                    <stop offset="27%" stop-color="hsl(97, 100%, 50%)"/>
                    <stop offset="28%" stop-color="hsl(100, 100%, 50%)"/>
                    <stop offset="29%" stop-color="hsl(104, 100%, 50%)"/>
                    <stop offset="30%" stop-color="hsl(108, 100%, 50%)"/>
                    <stop offset="31%" stop-color="hsl(111, 100%, 50%)"/>
                    <stop offset="32%" stop-color="hsl(115, 100%, 50%)"/>
                    <stop offset="33%" stop-color="hsl(118, 100%, 50%)"/>
                    <stop offset="34%" stop-color="hsl(122, 100%, 50%)"/>
                    <stop offset="35%" stop-color="hsl(126, 100%, 50%)"/>
                    <stop offset="36%" stop-color="hsl(129, 100%, 50%)"/>
                    <stop offset="37%" stop-color="hsl(133, 100%, 50%)"/>
                    <stop offset="38%" stop-color="hsl(136, 100%, 50%)"/>
                    <stop offset="39%" stop-color="hsl(140, 100%, 50%)"/>
                    <stop offset="40%" stop-color="hsl(144, 100%, 50%)"/>
                    <stop offset="41%" stop-color="hsl(147, 100%, 50%)"/>
                    <stop offset="42%" stop-color="hsl(151, 100%, 50%)"/>
                    <stop offset="43%" stop-color="hsl(154, 100%, 50%)"/>
                    <stop offset="44%" stop-color="hsl(158, 100%, 50%)"/>
                    <stop offset="45%" stop-color="hsl(162, 100%, 50%)"/>
                    <stop offset="46%" stop-color="hsl(165, 100%, 50%)"/>
                    <stop offset="47%" stop-color="hsl(169, 100%, 50%)"/>
                    <stop offset="48%" stop-color="hsl(172, 100%, 50%)"/>
                    <stop offset="49%" stop-color="hsl(176, 100%, 50%)"/>
                    <stop offset="50%" stop-color="hsl(180, 100%, 50%)"/>
                    <stop offset="51%" stop-color="hsl(183, 100%, 50%)"/>
                    <stop offset="52%" stop-color="hsl(187, 100%, 50%)"/>
                    <stop offset="53%" stop-color="hsl(190, 100%, 50%)"/>
                    <stop offset="54%" stop-color="hsl(194, 100%, 50%)"/>
                    <stop offset="55%" stop-color="hsl(198, 100%, 50%)"/>
                    <stop offset="56%" stop-color="hsl(201, 100%, 50%)"/>
                    <stop offset="57%" stop-color="hsl(205, 100%, 50%)"/>
                    <stop offset="58%" stop-color="hsl(208, 100%, 50%)"/>
                    <stop offset="59%" stop-color="hsl(212, 100%, 50%)"/>
                    <stop offset="60%" stop-color="hsl(216, 100%, 50%)"/>
                    <stop offset="61%" stop-color="hsl(219, 100%, 50%)"/>
                    <stop offset="62%" stop-color="hsl(223, 100%, 50%)"/>
                    <stop offset="63%" stop-color="hsl(226, 100%, 50%)"/>
                    <stop offset="64%" stop-color="hsl(230, 100%, 50%)"/>
                    <stop offset="65%" stop-color="hsl(234, 100%, 50%)"/>
                    <stop offset="66%" stop-color="hsl(237, 100%, 50%)"/>
                    <stop offset="67%" stop-color="hsl(241, 100%, 50%)"/>
                    <stop offset="68%" stop-color="hsl(244, 100%, 50%)"/>
                    <stop offset="69%" stop-color="hsl(248, 100%, 50%)"/>
                    <stop offset="70%" stop-color="hsl(252, 100%, 50%)"/>
                    <stop offset="71%" stop-color="hsl(255, 100%, 50%)"/>
                    <stop offset="72%" stop-color="hsl(259, 100%, 50%)"/>
                    <stop offset="73%" stop-color="hsl(262, 100%, 50%)"/>
                    <stop offset="74%" stop-color="hsl(266, 100%, 50%)"/>
                    <stop offset="75%" stop-color="hsl(270, 100%, 50%)"/>
                    <stop offset="76%" stop-color="hsl(273, 100%, 50%)"/>
                    <stop offset="77%" stop-color="hsl(277, 100%, 50%)"/>
                    <stop offset="78%" stop-color="hsl(280, 100%, 50%)"/>
                    <stop offset="79%" stop-color="hsl(284, 100%, 50%)"/>
                    <stop offset="80%" stop-color="hsl(288, 100%, 50%)"/>
                    <stop offset="81%" stop-color="hsl(291, 100%, 50%)"/>
                    <stop offset="82%" stop-color="hsl(295, 100%, 50%)"/>
                    <stop offset="83%" stop-color="hsl(298, 100%, 50%)"/>
                    <stop offset="84%" stop-color="hsl(302, 100%, 50%)"/>
                    <stop offset="85%" stop-color="hsl(306, 100%, 50%)"/>
                    <stop offset="86%" stop-color="hsl(309, 100%, 50%)"/>
                    <stop offset="87%" stop-color="hsl(313, 100%, 50%)"/>
                    <stop offset="88%" stop-color="hsl(316, 100%, 50%)"/>
                    <stop offset="89%" stop-color="hsl(320, 100%, 50%)"/>
                    <stop offset="90%" stop-color="hsl(324, 100%, 50%)"/>
                    <stop offset="91%" stop-color="hsl(327, 100%, 50%)"/>
                    <stop offset="92%" stop-color="hsl(331, 100%, 50%)"/>
                    <stop offset="93%" stop-color="hsl(334, 100%, 50%)"/>
                    <stop offset="94%" stop-color="hsl(338, 100%, 50%)"/>
                    <stop offset="95%" stop-color="hsl(342, 100%, 50%)"/>
                    <stop offset="96%" stop-color="hsl(345, 100%, 50%)"/>
                    <stop offset="97%" stop-color="hsl(349, 100%, 50%)"/>
                    <stop offset="98%" stop-color="hsl(352, 100%, 50%)"/>
                    <stop offset="99%" stop-color="hsl(356, 100%, 50%)"/>
                </linearGradient>
            </defs>

            <rect x="0" y="0" rx="0" ry="0" width="208" height="24" fill="url(#Gradient1)"/>
        </svg>

        <div class="absolute pointer-events-none top-0 w-6 rounded-full h-6 border-2 border-white transform -translate-x-3"
             :style="{ left: huePos + '%', background: 'hsl(' + hue + ', 100%, 50%)' }"></div>
    </div>

    <!-- Input Hexadécimal -->
    <input type="text" x-model="selectedHex" maxlength="7"
           class="w-full mt-2 p-2 text-xl bg-primary-100 text-center focus:outline-none"
           @input="updateFromHex(); $dispatch('color-picked', { hex: selectedHex, cindex: cindex })">

    <div class="flex">
        <!-- Bouton randomize -->
        <button type="button"
                @click="randomizeColor(); $dispatch('color-picked', { hex: selectedHex, cindex: cindex })"
                class="w-full text-primary bg-inactiveText text-xl p-2 group hover:bg-purple-500 transition-all duration-75">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-8 mx-auto group-hover:rotate-45 group-hover:scale-110 group-active:scale-90 transition-all duration-75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
        </button>

        <!-- Bouton copier -->
        <button type="button"
                @click="copyHex, copy = '{{ __('barbofus.contentCopied') }}'"
                class="w-full text-primary text-xl p-2 transition-all"
                :class="copy ? 'bg-secondary' : 'goldGradient hover:tracking-wider'"
                x-text="copy ? copy : '{{ __('barbofus.contentCopy') }}'" />
    </div>
</div>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("colorPicker", (initialColor) => ({
            showPicker: false,
            selectedHex: initialColor,
            hue: 0,
            huePos: 0,
            selectedPos: { x: 100, y: 0 },
            copy: null,
            cindex: null,
            inputPosition: { x: 0, y: 0},

            showColorPicker(event) {
                this.showPicker = true;
                this.selectedHex = event.detail.hex;
                this.cindex = event.detail.cindex;
                this.inputPosition = {
                    x: event.detail.inputPosition.x,
                    y: event.detail.inputPosition.y,
                }
                this.updateFromHex()
            },

            randomizeColor() {
                this.selectedHex = '#'+(Math.random() * 0xFFFFFF << 0).toString(16).padStart(6, '0');
                this.updateFromHex();
            },

            clamp(value, min, max) {
                return Math.max(min, Math.min(max, value));
            },

            openPicker(colorRef) {
                this.selectedHex = colorRef;
                this.showPicker = true;
            },

            pickColor(event) {
                let rect = document.getElementById('color-picker-hex').getBoundingClientRect();
                let x = this.clamp((event.clientX - rect.left) / rect.width * 100, 0, 100);
                let y = this.clamp((event.clientY - rect.top) / rect.height * 100, 0, 100);
                this.selectedPos = { x, y };
            },

            pickHue(event) {
                let rect = document.getElementById('color-picker-hue').getBoundingClientRect();
                let x = this.clamp((event.clientX - rect.left) / rect.width * 100, 0, 100);
                this.huePos = x;
                this.hue = x * 3.6;
            },

            updateColor() {
                this.copy = null;
                this.selectedHex = this.hsvToHex(this.hue, this.selectedPos.x, 100-this.selectedPos.y);
            },

            updateFromHex() {
                this.copy = null;
                this.selectedHex = '#' + this.selectedHex.replace(/[^0-9a-fA-F]/g, '').slice(0, 6);
                if (/^#[0-9A-F]{6}$/i.test(this.selectedHex)) {
                    this.selectedHex = this.selectedHex.toLowerCase();

                    const hsl = this.hexToHsl(this.selectedHex);
                    this.hue = hsl.h;
                    this.huePos = hsl.h / 3.6;

                    const hsv = this.hexToHsv(this.selectedHex);
                    this.selectedPos =  { x: hsv.s, y: 100-hsv.v };
                }
            },

            copyHex() {
                navigator.clipboard.writeText(this.selectedHex);
            },

            hsvToHex(h, s, v) {
                s /= 100;
                v /= 100;
                let c = v * s;
                let x = c * (1 - Math.abs((h / 60) % 2 - 1));
                let m = v - c;
                let r = 0, g = 0, b = 0;

                if (h >= 0 && h < 60) {
                    r = c; g = x; b = 0;
                } else if (h >= 60 && h < 120) {
                    r = x; g = c; b = 0;
                } else if (h >= 120 && h < 180) {
                    r = 0; g = c; b = x;
                } else if (h >= 180 && h < 240) {
                    r = 0; g = x; b = c;
                } else if (h >= 240 && h < 300) {
                    r = x; g = 0; b = c;
                } else {
                    r = c; g = 0; b = x;
                }

                r = Math.round((r + m) * 255);
                g = Math.round((g + m) * 255);
                b = Math.round((b + m) * 255);

                return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
            },

            hexToHsv(hex) {
                // Convertir hex en RGB
                let r = parseInt(hex.substring(1, 3), 16) / 255;
                let g = parseInt(hex.substring(3, 5), 16) / 255;
                let b = parseInt(hex.substring(5, 7), 16) / 255;

                let max = Math.max(r, g, b), min = Math.min(r, g, b);
                let delta = max - min;
                let h = 0, s = 0, v = max;

                if (delta !== 0) {
                    s = delta / max;

                    if (max === r) {
                        h = 60 * (((g - b) / delta) % 6);
                    } else if (max === g) {
                        h = 60 * (((b - r) / delta) + 2);
                    } else {
                        h = 60 * (((r - g) / delta) + 4);
                    }
                }

                if (h < 0) h += 360;

                return {
                    h: Math.round(h),
                    s: Math.round(s * 100),
                    v: Math.round(v * 100)
                };
            },

            hexToHsl(H) {
                let r = 0, g = 0, b = 0;
                if (H.length == 4) {
                    r = "0x" + H[1] + H[1];
                    g = "0x" + H[2] + H[2];
                    b = "0x" + H[3] + H[3];
                } else if (H.length == 7) {
                    r = "0x" + H[1] + H[2];
                    g = "0x" + H[3] + H[4];
                    b = "0x" + H[5] + H[6];
                }
                // Then to HSL
                r /= 255;
                g /= 255;
                b /= 255;
                let cmin = Math.min(r,g,b),
                    cmax = Math.max(r,g,b),
                    delta = cmax - cmin,
                    h = 0,
                    s = 0,
                    l = 0;

                if (delta == 0)
                    h = 0;
                else if (cmax == r)
                    h = ((g - b) / delta) % 6;
                else if (cmax == g)
                    h = (b - r) / delta + 2;
                else
                    h = (r - g) / delta + 4;

                h = Math.round(h * 60);

                if (h < 0)
                    h += 360;

                l = (cmax + cmin) / 2;
                s = delta == 0 ? 0 : delta / (1 - Math.abs(2 * l - 1));
                s = +(s * 100).toFixed(1);
                l = +(l * 100).toFixed(1);

                return {
                    h: h,
                    s: s,
                    l: l,
                };
            },

            hslToHex(h, s, l) {
                l /= 100;
                const a = s * Math.min(l, 1 - l) / 100;
                const f = n => {
                    const k = (n + h / 30) % 12;
                    const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
                    return Math.round(255 * color).toString(16).padStart(2, '0');   // convert to Hex and prefix "0" if needed
                };
                return `#${f(0)}${f(8)}${f(4)}`;
            }
        }));
    });
</script>
