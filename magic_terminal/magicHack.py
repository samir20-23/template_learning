import math, time, os

A = 0
B = 0

while True:
    os.system('cls' if os.name == 'nt' else 'clear')
    z = [' '] * 1760
    b = [0] * 1760
    for j in range(0, 628, 7):
        for i in range(0, 628, 2):
            c, d, e, f, g, h = math.sin(i), math.cos(j), math.sin(A), math.sin(j), math.cos(A), math.cos(i)
            D = 1 / (c * f * g + d * h + 5)
            l = int(40 + 30 * D * (h * g - c * d * f))
            m = int(12 + 15 * D * (h * d + c * g * f))
            n = int(l + 80 * m)
            if 0 <= m < 22 and 0 <= l < 80 and D > b[n]:
                b[n] = D
                z[n] = '.,-~:;=!*#$@'[int(8 * ((d * e - c * h * f) / 2 + 1))]
    
    print('\x1b[H' + ''.join(z))
    A += 0.04
    B += 0.08
    time.sleep(0.03)
