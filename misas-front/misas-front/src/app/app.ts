import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { Locacionespage } from './pages/locaciones.page';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet,
    Locacionespage
  ],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
  protected readonly title = signal('misas-front');
}
