<script lang="ts">
import { Form, Head, useForm } from '@inertiajs/vue3';

import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';

const form = useForm({
    nome: '',
    email: '',
    cpf: '',
    comissao: '',
    cep: '',
    rua: '',
    numero: '',
    complemento: '',
    bairro: '',
    cidade: '',
    estado: '',
});

function onComissaoInput(e: InputEvent) {
    const el = e.target as HTMLInputElement;
    let v = el.value;

    // aceita vírgula como separador decimal
    v = v.replace(',', '.');

    // apenas números e ponto
    v = v.replace(/[^\d.]/g, '');

    // apenas UM ponto
    const dotIndex = v.indexOf('.');
    if (dotIndex !== -1) {
        v = v.slice(0, dotIndex + 1) + v.slice(dotIndex + 1).replace(/\./g, '');
    }

    // se começa com ponto, prefixa 0
    if (v.startsWith('.')) {
        v = '0' + v;
    }

    // limita a 1 casa decimal
    if (v.includes('.')) {
        const [intPart, decPart] = v.split('.');
        v = intPart + '.' + decPart.slice(0, 1);
    }

    // bloqueia valores acima de 100
    const n = Number(v);
    if (!isNaN(n) && n > 100) {
        v = '100';
    }

    // se for exatamente 100, não permite ponto
    if (v === '100.' || v.startsWith('100.')) {
        v = '100';
    }

    form.comissao = v;
}

function onComissaoBlur() {
    if (!form.comissao) return;

    let n = Number(form.comissao.replace(',', '.'));

    if (isNaN(n)) {
        form.comissao = '';
        return;
    }

    // Limita o valor de comissão entre 0 e 100
    n = Math.max(0, Math.min(100, n));

    // Remove o ponto desnecessário
    form.comissao = Number.isInteger(n) ? String(n) : n.toFixed(1);
}

function viaCepLookup(cep: string) {
    cep = cep.replace(/\D/g, ''); // Remove caracteres não numéricos
    fetch(`https://viacep.com.br/ws/${cep}/json/`)  // Corrigido aqui
        .then((response) => response.json())
        .then((data) => {
            form.rua = data.logradouro || '';
            form.bairro = data.bairro || '';
            form.cidade = data.localidade || '';
            form.estado = data.uf || '';
        })
        .catch((error) => {
            console.error('Erro ao buscar CEP:', error);
        });
}

// Função para enviar os dados ao backend
function submit() {
    form.post('/vendedores');  // Exemplo de envio para a rota /vendedores
}

export default {
  components: {
    Heading,
    InputError,
    Button,
    Input,
    Label,
    Separator,
    AppLayout
  },
  methods: {
    submit
  }
}
</script>

<template>
    <Head title="Vendedor" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Vendedores" description="Cria vendedores" />

            <div class="md:grid-cols 4 grid-cols-1">
                <div class="relative min-h-screen flex-1 rounded-xl border p-4">

                    <!-- Formulário com a diretiva de envio -->
                    <Form @submit.prevent="submit">
                        <Heading title="Informações pessoais" />

                        <div class="mb-4 grid grid-cols-1 gap-6 md:grid-cols-3">
                            <!-- NOME -->
                            <div class="grid gap-2">
                                <Label for="nome">Nome</Label>
                                <Input
                                    id="nome"
                                    v-model="form.nome"
                                    type="text"
                                    autofocus
                                    :tabindex="1"
                                    name="nome"
                                    placeholder="Nome completo"
                                />
                                <InputError :message="form.errors.nome" />
                            </div>

                            <!-- EMAIL -->
                            <div class="grid gap-2">
                                <Label for="email">Email</Label>
                                <Input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    placeholder="email@exemplo.com"
                                />
                                <InputError :message="form.errors.email" />
                            </div>

                            <!-- CPF -->
                            <div class="grid gap-2">
                                <Label for="cpf">CPF</Label>
                                <Input
                                    id="cpf"
                                    v-model="form.cpf"
                                    type="text"
                                    placeholder="000.000.000-00"
                                />
                                <InputError :message="form.errors.cpf" />
                            </div>
                        </div>

                        <Separator />
                        <Heading title="Informações adicionais" class="mt-4" />

                        <!-- COMISSÃO -->
                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-3">
                            <div class="grid gap-2">
                                <Label for="comissao">Comissão</Label>
                                <Input
                                    id="comissao"
                                    v-model="form.comissao"
                                    type="text"
                                    placeholder="0.0%"
                                    @input="onComissaoInput"
                                    @blur="onComissaoBlur"
                                />
                                <InputError :message="form.errors.comissao" />
                            </div>
                        </div>

                        <Separator />
                        <Heading title="Endereço" class="mt-4" />

                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-3">
                            <!-- CEP -->
                            <div class="grid gap-2">
                                <Label for="cep">CEP</Label>
                                <Input
                                    id="cep"
                                    v-model="form.cep"
                                    @blur="viaCepLookup(form.cep)"
                                    type="text"
                                    placeholder="00000-000"
                                />
                                <InputError :message="form.errors.cep" />
                            </div>

                            <!-- RUA -->
                            <div class="grid gap-2">
                                <Label for="rua">Rua</Label>
                                <Input
                                    id="rua"
                                    v-model="form.rua"
                                    type="text"
                                    placeholder="Rua"
                                />
                            </div>

                            <!-- NUMERO -->
                            <div class="grid gap-2">
                                <Label for="numero">Número</Label>
                                <Input
                                    id="numero"
                                    v-model="form.numero"
                                    type="text"
                                    placeholder="Número"
                                />
                            </div>

                            <!-- COMPLEMENTO -->
                            <div class="grid gap-2">
                                <Label for="complemento">Complemento</Label>
                                <Input
                                    id="complemento"
                                    v-model="form.complemento"
                                    type="text"
                                    placeholder="Complemento"
                                />
                            </div>

                            <!-- BAIRRO -->
                            <div class="grid gap-2">
                                <Label for="bairro">Bairro</Label>
                                <Input
                                    id="bairro"
                                    v-model="form.bairro"
                                    type="text"
                                    placeholder="Bairro"
                                />
                            </div>

                            <!-- CIDADE -->
                            <div class="grid gap-2">
                                <Label for="cidade">Cidade</Label>
                                <Input
                                    id="cidade"
                                    v-model="form.cidade"
                                    type="text"
                                    placeholder="Cidade"
                                />
                            </div>

                            <!-- ESTADO -->
                            <div class="grid gap-2">
                                <Label for="estado">Estado</Label>
                                <Input
                                    id="estado"
                                    v-model="form.estado"
                                    type="text"
                                    placeholder="UF"
                                />
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-5">
                            <Button type="submit" class="mt-2 w-full">
                                Salvar Vendedor
                            </Button>
                        </div>

                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
