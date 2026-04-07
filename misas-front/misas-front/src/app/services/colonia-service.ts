import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class ColoniaService {
  private apiURL = "http://localhost/api/colonias/ciudad/";

  constructor(private http: HttpClient) {}

  getByCiudad(ciudadId: number) {
    return this.http.get<any[]>(`${this.apiURL}${ciudadId}`);
  }
}
