import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class ColoniaService {
  private apiURL = "http://localhost/api/colonias";

  constructor(private http: HttpClient) {}

  getAll() {
    return this.http.get<any[]>(this.apiURL);
  }

  getByCiudad(ciudadId: number) {
    return this.http.get<any[]>(`${this.apiURL}${ciudadId}`);
  }

  create(colonia: any) {
    return this.http.post(this.apiURL, colonia);
  }

}
