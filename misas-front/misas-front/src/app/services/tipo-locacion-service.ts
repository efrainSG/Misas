import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class TipoLocacionService {
  private apiURL = "http://localhost/api/tiposLocaciones";

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

  create(tipoLocacion: any) {
    return this.http.post(this.apiURL, tipoLocacion);
  }

  update(id: number, tipoLocacion: any) {
    return this.http.put(`${this.apiURL}/${id}`, tipoLocacion);
  }

  delete(id: number) {
    return this.http.delete(`${this.apiURL}/${id}`);
  }
}
