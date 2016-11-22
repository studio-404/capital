<?php 
class searchStatement
{
	public $out; 
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$pid = functions\request::index("POST","pid");

		$statements = new Database('statements', array(
			'method'=>'selectByPersonalNumber', 
			'pid'=>$pid
		));
		$getter = $statements->getter();

		$table = '<table class="striped"><tbody>';
		if(count($getter)) {
			foreach ($getter as $val) {
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'ს.კ.: ',
					$val['id']
				);
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'დამატების თარიღი: ',
					date("d/m/Y H:i:s", $val['date'])
				);
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'IP მისამართი: ',
					$val['ip']
				);
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'პირადი ნომერი: ',
					$val['personal_number']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'სესხის ტიპი: ',
					$val['loantype']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'სახელი: ',
					$val['name']
				);
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'გვარი: ',
					$val['surname']
				);
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'დაბადების თარიღი: ',
					$val['dob']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'სქესი: ',
					$val['gender']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'ელ-ფოსტა: ',
					$val['email']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'ტელეფონი: ',
					$val['phone']
				);

				$cities = new Database('cities', array(
					'method'=>'selectById', 
					'id'=>$val['city']
				));
				$city_name = $cities->getter();

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'ქალაქი:',
					$city_name
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'ქუჩა:',
					$val['street']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'სახლი:',
					$val['house']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'ბინა:',
					$val['room']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'საფოსტო კოდი:',
					$val['postal_code']
				);
				
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'ყოველთვიური შემოსავალი:',
					$val['monthly_income']
				);

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'მიმდინარე სესხი:',
					$val['loans']
				);

				// $table .= sprintf("
				// 	<tr>
				// 	<td><strong>%s</strong></td>
				// 	<td>%s</td>
				// 	</tr>",
				// 	'მოთხოვნილი სესხი:',
				// 	$val['demended_loan']
				// );

				// $table .= sprintf("
				// 	<tr>
				// 	<td><strong>%s</strong></td>
				// 	<td>%s</td>
				// 	</tr>",
				// 	'მოთხოვნილი თვე:',
				// 	$val['demended_month']
				// );

				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'პაროლი:',
					$val['password']
				);
				
			}
		}else{
			$table .= sprintf("
					<tr>
					<td colspan=\"2\">%s</td>
					</tr>",
					'მონაცემი ვერ მოიძებნა !'
			);
		}
		$table .= '</table></tbody>';

		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"Details"=>""
			),
			"table" => $table
		);	

		return $this->out;
	}
}