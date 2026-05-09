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

  getById(id: number) {
    return this.http.get<any>(`${this.apiURL}/${id}`);
  }

  getByNombre(nombre: string) {
    return this.http.get<any>(`${this.apiURL}/nombre/${nombre}`);
  }

  create(ciudad: any) {
    return this.http.post(this.apiURL, ciudad);
  }

  update(id: number, ciudad: any) {
    return this.http.put(`${this.apiURL}/${id}`, ciudad);
  }

  delete(id: number) {
    return this.http.delete(`${this.apiURL}/${id}`);
  }
}
