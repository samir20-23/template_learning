import { Component } from '@angular/core';

@Component({
  selector: 'app-add-card',
  standalone: true,
  imports: [],
  templateUrl: './add-card.component.html',
  styleUrl: './add-card.component.css'
})

export class AddCardComponent {
  // Properties for card details
  cardholder: string = '';
  cardNumber: string = '';
  expired = {
    month: '',
    year: '',
  };
  securityCode: string = '';
  card: 'front' | 'back' = 'front';

  constructor() {
    console.log('Component mounted');
  }

  /**
   * Formats the card number to include spaces every 4 digits.
   */
  formatCardNumber(): void {
    if (this.cardNumber.length > 19) {
      return;
    }
    this.cardNumber = this.cardNumber.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ').trim();
  }

  /**
   * Getter to validate the card details.
   * Ensures all fields are correctly filled out.
   */
  get isValid(): boolean {
    if (this.cardholder.length < 5) {
      return false;
    }
    if (this.cardNumber === '') {
      return false;
    }
    if (this.expired.month === '' || this.expired.year === '') {
      return false;
    }
    if (this.securityCode.length !== 3) {
      return false;
    }
    return true;
  }

  /**
   * Handles the submission of the card details.
   */
  onSubmit(): void {
    alert(`You did it, ${this.cardholder}!`);
  }
}

