import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ApiResponse } from '../interfaces/ApiResponse';

@Injectable({
  providedIn: 'root',
})
export class TipoLocacionService {
  private apiURL = "http://localhost/api/tiposLocaciones";

  constructor(private http: HttpClient) {}

  getAll() {
    return this.http.get<ApiResponse<any[]>>(this.apiURL);
  }

  getById(id: number) {
    return this.http.get<ApiResponse<any>>(`${this.apiURL}/${id}`);
  }

  getByNombre(nombre: string) {
    return this.http.get<ApiResponse<any[]>>(`${this.apiURL}/nombre/${nombre}`);
  }

  create(tipoLocacion: any) {
    return this.http.post<ApiResponse<any>>(this.apiURL, tipoLocacion);
  }

  update(id: number, tipoLocacion: any) {
    return this.http.put<ApiResponse<any>>(`${this.apiURL}/${id}`, tipoLocacion);
  }

  delete(id: number) {
    return this.http.delete<ApiResponse<any>>(`${this.apiURL}/${id}`);
  }
}
