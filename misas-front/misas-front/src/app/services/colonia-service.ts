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

  getAllDescriptive() {
    return this.http.get<any[]>(`${this.apiURL}/descriptivas`);
  }

  getByCiudad(ciudadId: number) {
    return this.http.get<any[]>(`${this.apiURL}/ciudad/${ciudadId}`);
  }

  getById(id: number) {
    return this.http.get<any>(`${this.apiURL}/${id}`);
  }
  
  getByNombre(nombre: string) {
    return this.http.get<any[]>(`${this.apiURL}/nombre/${nombre}`);
  }

  create(colonia: any) {
    return this.http.post(this.apiURL, colonia);
  }

  update(id: number, colonia: any) {
    return this.http.put(`${this.apiURL}/${id}`, colonia);
  }

  delete(id: number) {
    return this.http.delete(`${this.apiURL}/${id}`);
  }

}
