import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class LocationService {
  private apiURL = "http://localhost/api/locaciones";
  
  constructor(private http: HttpClient) {}

  getAll() {
    return this.http.get<any[]>(this.apiURL);
  }

  getAllDescriptive() {
    return this.http.get<any[]>(`${this.apiURL}/descriptivas`);
  }
  
  getById(id: number) {
    return this.http.get<any>(`${this.apiURL}/${id}`);
  }

  getByNombre(nombre: string) {
    return this.http.get<any[]>(`${this.apiURL}/nombre/${nombre}`);
  }

  getByColonia(coloniaId: number) {
    return this.http.get<any[]>(`${this.apiURL}/byColonia/${coloniaId}`);
  }

  getByTipo(tipoLocacionId: number) {
    return this.http.get<any[]>(`${this.apiURL}/byTipo/${tipoLocacionId}`);
  }

  getHorariosByLocacionId(locacionId: number) {
    return this.http.get<any[]>(`${this.apiURL}/${locacionId}/horarios`);
  }

  getByTipoAndColonia(tipoLocacionId: number, coloniaId: number) {
    return this.http.get<any[]>(`${this.apiURL}/byTipoAndColonia/${tipoLocacionId}/${coloniaId}`);
  }

  create(location: any) {
    return this.http.post(this.apiURL, location);
  }

  update(id: number, location: any) {
    return this.http.put(`${this.apiURL}/${id}`, location);
  }

  delete(id: number) {
    return this.http.delete(`${this.apiURL}/${id}`);
  }
}
