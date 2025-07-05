import { Component, OnInit, Inject, PLATFORM_ID } from '@angular/core';
import { CommonModule, isPlatformBrowser } from '@angular/common';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css'], // Fixed typo: `styleUrl` to `styleUrls`
})
export class NavbarComponent implements OnInit {
  isBrowser: boolean;

  constructor(@Inject(PLATFORM_ID) private platformId: Object) {
    // Check if the code is running in the browser
    this.isBrowser = isPlatformBrowser(this.platformId);
  }

  ngOnInit(): void {
    if (this.isBrowser) {
      // Add event listeners only in the browser
      this.initializeNavbar();
    }
  }

  initializeNavbar(): void {
    // Burger menus
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
      burger.forEach((btn) => {
        btn.addEventListener('click', () => {
          menu.forEach((nav) => nav.classList.toggle('hidden'));
        });
      });
    }

    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
      close.forEach((btn) => {
        btn.addEventListener('click', () => {
          menu.forEach((nav) => nav.classList.toggle('hidden'));
        });
      });
    }
    if (backdrop.length) {
      backdrop.forEach((bg) => {
        bg.addEventListener('click', () => {
          menu.forEach((nav) => nav.classList.toggle('hidden'));
        });
      });
    }
  }
}
