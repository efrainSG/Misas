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

    create(horario: any) {
        return this.http.post(this.apiURL, horario);
    }
}