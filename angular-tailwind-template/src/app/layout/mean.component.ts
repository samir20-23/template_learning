import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';
import { LoginComponent } from '../auth/login/login.component';
import { AddCardComponent } from '../add-card/add-card.component';
import { DashboardComponent } from '../dashboard/dashboard.component';
import { DetailsComponent } from '../details/details.component';

@Component({
  selector: 'app-mean',
  standalone: true,
  imports: [
    CommonModule,
    NavbarComponent,
    FooterComponent,
    LoginComponent,
    AddCardComponent,
    DashboardComponent,
    DetailsComponent,

  ],
  templateUrl: './mean.component.html',
  styleUrl: './mean.component.css'
})
export class MeanComponent {

}
