import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class CiudadService {
  private apiURL = "http://localhost/api/ciudades";

  constructor(private http: HttpClient) {}

  getAll() {
    return this.http.get<any[]>(this.apiURL);
  }

  create(ciudad: any) {
    return this.http.post(this.apiURL, ciudad);
  }
}
