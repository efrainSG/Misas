import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";

@Injectable({
    providedIn: 'root',
})
export class HorarioService {
    private apiURL = "http://localhost/api/horarios";

    constructor(private http: HttpClient) {}

    getAll() {
        return this.http.get<any[]>(this.apiURL);
    }

    getById(id: number) {
        return this.http.get<any>(`${this.apiURL}/${id}`);
    }

    getByHora(hora: string) {
        return this.http.get<any[]>(`${this.apiURL}/hora/${hora}`);
    }

    getByDia(dia: string) {
        return this.http.get<any[]>(`${this.apiURL}/dia/${dia}`);
    }

    getByActivo(activo: boolean) {
        return this.http.get<any[]>(`${this.apiURL}/activo/${activo}`);
    }

    getByLocacionId(locacionId: number) {
        return this.http.get<any[]>(`${this.apiURL}/locacion/${locacionId}`);
    }

    create(horario: any) {
        return this.http.post(this.apiURL, horario);
    }

    update(id: number, horario: any) {
        return this.http.put(`${this.apiURL}/${id}`, horario);
    }

    delete(id: number) {
        return this.http.delete(`${this.apiURL}/${id}`);
    }
}