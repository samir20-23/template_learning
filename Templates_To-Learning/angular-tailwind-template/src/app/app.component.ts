import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { MeanComponent } from "./layout/mean.component";

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, MeanComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'bank';
}
